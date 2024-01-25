import psycopg
import os
from os.path import dirname, abspath
from dotenv import load_dotenv
load_dotenv()
import uuid
import requests
import datetime
from julia import Julia
jl = Julia(sysimage="scripts/sys.so")
from julia import Main

Main.include("scripts/hypergraphs.jl")

DB_U= os.getenv("DB_USERNAME")
DB_P= os.getenv("DB_PASSWORD")
DB_D= os.getenv("DB_DATABASE")
DB_H= os.getenv("DB_HOST")
GIT_U= os.getenv("GIT_USERNAME")
GIT_T= os.getenv("GIT_TOKEN")
# repo in same root
# d = dirname(dirname(dirname(abspath(__file__))))
# datasets = d + "/datasets"

print("Executed at: ", datetime.datetime.now())

d = dirname(dirname(abspath(__file__)))
datasets = d + "/storage/app/public/datasets"

############################
# delete old categories who are not in the repo anymore
cnx = psycopg.connect(host=DB_H, user=DB_U, password=DB_P, dbname=DB_D)
cursor = cnx.cursor()
delete_old_categories = ("""DELETE FROM categories 
                            WHERE id NOT IN (SELECT category_id FROM hgraphs_categories)""")
cursor.execute(delete_old_categories)
cnx.commit()
cnx.close()
############################

############################
# add empty category if not present
cnxEmpty = psycopg.connect(host=DB_H, user=DB_U, password=DB_P, dbname=DB_D)
category = "empty"
search_empty = ("SELECT * FROM categories WHERE type = '"+category+"'")
cursor = cnxEmpty.cursor()
cursor.execute(search_empty)
result = cursor.fetchall()
if len(result) == 0:
    myuuid_empty_category = uuid.uuid4()
    cursor = cnxEmpty.cursor()
    add_category = ("INSERT INTO categories (id, type)"
                    " VALUES ('"+str(myuuid_empty_category)+"', '"+str(category)+"')")
    cursor.execute(add_category)
    cnxEmpty.commit()
cnxEmpty.close()
############################

############################
# delete old hgraphs who are not in the repo anymore
cnx = psycopg.connect(host=DB_H, user=DB_U, password=DB_P, dbname=DB_D)
search_hgraph = ("SELECT name FROM hgraphs")
cursor = cnx.cursor()
cursor.execute(search_hgraph)
result = cursor.fetchall()
cnx.close()
list_hgraph_db = []
list_hgraph_repo = []
for row in result:
    list_hgraph_db.append(row[0])
for filename in os.listdir(datasets):
    f = os.path.join(datasets, filename)
    if os.path.isdir(f) and not filename.startswith(".") and not filename == "scripts":
        list_hgraph_repo.append(filename)
for hgraph in list_hgraph_db:
    if hgraph not in list_hgraph_repo:
        print("deleting ", hgraph)
        cnx = psycopg.connect(host=DB_H, user=DB_U, password=DB_P, dbname=DB_D)
        cursor = cnx.cursor()
        delete_hgraph = ("DELETE FROM hgraphs WHERE name = '"+str(hgraph)+"'")
        cursor.execute(delete_hgraph)
        cnx.commit()
        cnx.close()
############################

for filename in os.listdir(datasets):
    f = os.path.join(datasets, filename)
    # checking if it is a directory and not a hidden directory
    if os.path.isdir(f) and not filename.startswith(".") and not filename == "scripts":
        cnx = psycopg.connect(host=DB_H, user=DB_U, password=DB_P, dbname=DB_D)
        # sql query to search for the name of the folder
        search_hgraph = ("SELECT * FROM hgraphs WHERE name = '"+str(filename)+"'")
        cursor = cnx.cursor()
        cursor.execute(search_hgraph)
        result = cursor.fetchall()

        # if the hgraph is not in the database
        if len(result) == 0:
            apiCall = "https://api.github.com/repos/HypergraphRepository/datasets/commits?path=" + filename + "/" + filename + ".hgf"
            response = requests.get(apiCall, auth=(GIT_U, GIT_T))
            res = response.json()
            myuuid = uuid.uuid4()

            last = len(res)-1
            first_commit = res[last]
            author = first_commit['commit']['author']['name']
            author_url = first_commit['author']['html_url']
            first_commit_date = first_commit['commit']['author']['date']
            last_commit = res[0]
            last_commit_date = last_commit['commit']['author']['date']
            
            created_at = first_commit_date.replace("T", " ")
            created_at = created_at.replace("Z", "")
            update_at = last_commit_date.replace("T", " ")
            update_at = update_at.replace("Z", "")

            # read the file
            categories_path = "./storage/app/public/datasets/" + filename + "/categories.info"
            # if the file is not present, create it
            categories_empty = "empty"
            domain = "empty"
            ###############
            # categories update
            if os.path.isfile(categories_path):
                read = open(categories_path, "r").read()
                categories = read.split("\n")
                my_domain = categories[0]
                domain = my_domain
                # exclude first two lines
                for category in categories[2:]:
                    if category == "":
                        continue
                    else:
                        # check if the category is already in the database
                        search_category = ("SELECT * FROM categories WHERE type = '"+str(category)+"'")
                        cursor = cnx.cursor()
                        cursor.execute(search_category)
                        result_category = cursor.fetchall()

                        myuuid_category = ""
                        if len(result_category) == 0:
                            # if the category is not in the database, add it
                            myuuid_category = uuid.uuid4()
                            cursor = cnx.cursor()
                            add_category = ("INSERT INTO categories (id, type)"
                                            " VALUES ('"+str(myuuid_category)+"', '"+str(category)+"')")
                            cursor.execute(add_category)
                            cnx.commit()
                        else:
                            # if the category is in the database, get the id
                            myuuid_category = result_category[0][0]

                        # insert the category in the hgraph_categories table
                        cursor = cnx.cursor()
                        myuuid_hgraph_category = uuid.uuid4()
                        add_hgraph_category = ("INSERT INTO hgraphs_categories (id, hgraph_id, category_id)"
                                        " VALUES ('"+str(myuuid_hgraph_category)+"', '"+str(myuuid)+"', '"+str(myuuid_category)+"')")
                        cursor.execute(add_hgraph_category)
            else:
                # add empty category
                search_category = ("SELECT * FROM categories WHERE type = '"+str(categories_empty)+"'")
                cursor = cnx.cursor()
                cursor.execute(search_category)
                result_category = cursor.fetchall()
                myuuid_hgraph_category = uuid.uuid4()
                # print(result_category)
                myuuid_category = result_category[0][0]
                add_hgraph_category = ("INSERT INTO hgraphs_categories (id, hgraph_id, category_id)"
                                        " VALUES ('"+str(myuuid_hgraph_category)+"', '"+str(myuuid)+"', '"+str(myuuid_category)+"')")
                cursor.execute(add_hgraph_category)
            ###############

            descr = "./storage/datasets/" + filename + "/README.md"
            # url = "https://github.com/HypergraphRepository/datasets" + filename + "/" + filename + ".hgf"
            url = "https://hypergraphrepository.di.unisa.it/download/" + filename
            pathToHg = "./storage/app/public/datasets/" + filename + "/" + filename + ".hgf"
            (nodes, edges, avg_node_degree, avg_edge_degree, distribution_node_degree, distribution_edge_size, node_degree_max, edge_degree_max, distribution_node_degree_hist, distribution_edge_size_hist) = Main.collect_infos(pathToHg)
            # sort distribution in ascending order

            distribution_node_degree.sort(reverse=True)
            distribution_node_degree = ",".join(str(x) for x in distribution_node_degree)
            distribution_edge_size.sort(reverse=True)
            distribution_edge_size = ",".join(str(x) for x in distribution_edge_size)
            summary = "test summary"
            add_hgraph= ("INSERT INTO hgraphs (id, name, summary, domain, author, authorurl, nodes, edges, dnodemax, dedgemax, dnodeavg, dedgeavg, dnodes, dedges, dedgeshist, dnodeshist, url, description, created_at, updated_at)"
                        #  " VALUES ('"+str(myuuid)+"', '"+str(filename)+"','" + author + "','" + str(nodes) + "','" + str(edges) + "','" + str(node_degree_max) + "','" + str(edge_degree_max) + "','" + str(avg_node_degree) + "','" + str(avg_edge_degree) + "','" + str(distribution_node_degree) + "','" + str(distribution_edge_size) + "','" + url +"', '" + categories + "','" + str(descr) + "','"+str(created_at)+"', '"+str(update_at)+"')")
                            " VALUES ('"+str(myuuid)+"', '"+str(filename)+"','" + str(summary) + "','" + str(domain) + "','" + author + "','" + author_url + "','" + str(nodes) + "','" + str(edges) + "','" + str(node_degree_max) + "','" + str(edge_degree_max) + "','" + str(avg_node_degree) + "','" + str(avg_edge_degree) + "','" + str(distribution_node_degree) + "','" + str(distribution_edge_size) + "','" + str(distribution_edge_size_hist) + "','" + str(distribution_node_degree_hist) + "','" + url +"', '" + str(descr) + "','"+str(created_at)+"', '"+str(update_at)+"')")
                # " VALUES ('"+str(myuuid)+"', '"+str(filename)+"','" + author + "','" + str(nodes) + "','" + str(edges) + "','" + url +"', '" + categories + "','" + str(descr) + "','"+str(created_at)+"', '"+str(update_at)+"')")    
            cursor.execute(add_hgraph)
            cnx.commit()
            cnx.close()
            continue
        # if the hgraph is already in the database
        else:
            db_row_UpdatedAt = result[0][len(result[0])-1]
            new_date = db_row_UpdatedAt
            for files in os.listdir(f):      
                if files.endswith(".hgf"):
                    apiCall = "https://api.github.com/repos/HypergraphRepository/datasets/commits?path=" + filename + "/" + filename + ".hgf"
                    response = requests.get(apiCall, auth=(GIT_U, GIT_T))
                    res = response.json()
                    # last commit on the file
                    res = res[0]
                    author = res['commit']['author']['name']
                    date = res['commit']['author']['date']
                    # format date
                    date = date.replace("T", " ")
                    date = date.replace("Z", "")

                    if str(db_row_UpdatedAt) < str(date):
                        if str(new_date) < str(date):
                            new_date = date
                        
                        pathToHg = "./storage/app/public/datasets/" + filename + "/" + filename + ".hgf"
                        (nodes, edges, avg_node_degree, avg_edge_degree, distribution_node_degree, distribution_edge_size, node_degree_max, edge_degree_max, distribution_node_degree_hist, distribution_edge_size_hist) = Main.collect_infos(pathToHg)                        
                        distribution_node_degree.sort(reverse=True)
                        distribution_node_degree = ",".join(str(x) for x in distribution_node_degree)
                        distribution_edge_size.sort(reverse=True)
                        distribution_edge_size = ",".join(str(x) for x in distribution_edge_size)
                        update_hgraph_stats = ("UPDATE hgraphs SET nodes = '"+str(nodes)+"', edges = '"+str(edges)+"' WHERE name = '"+str(filename)+"'")
                        cursor.execute(update_hgraph_stats)
                        cnx.commit()
                    
                if files.endswith(".md"):
                    apiCall = "https://api.github.com/repos/HypergraphRepository/datasets/commits?path=" + filename + "/README.md"
                    response = requests.get(apiCall, auth=(GIT_U, GIT_T))
                    res = response.json()
                    res = res[0]
                    author = res['commit']['author']['name']
                    date = res['commit']['author']['date']
                    # format date
                    date = date.replace("T", " ")
                    date = date.replace("Z", "")
                    if str(db_row_UpdatedAt) < str(date):
                        if str(new_date) < str(date):
                            new_date = date

                if files.endswith(".info"):
                    apiCall = "https://api.github.com/repos/HypergraphRepository/datasets/commits?path=" + filename + "/categories.info"
                    response = requests.get(apiCall, auth=(GIT_U, GIT_T))
                    res = response.json()
                    res = res[0]
                    author = res['commit']['author']['name']
                    date = res['commit']['author']['date']
                    # format date
                    date = date.replace("T", " ")
                    date = date.replace("Z", "")
                    if str(db_row_UpdatedAt) < str(date):
                        if str(new_date) < str(date):
                            new_date = date
                            # read the file
                            categories_path = "./storage/app/public/datasets/" + filename + "/categories.info"
                            
                            ###############
                            # update domain
                            read = open(categories_path, "r").read()
                            categories = read.split("\n")
                            my_domain = categories[0]
                            myuuid = result[0][0]
                            previous_domain = result[0][2]
                            if previous_domain != my_domain:
                                cursor = cnx.cursor()
                                update_hgraph = ("UPDATE hgraphs SET domain = '"+str(my_domain)+"' WHERE name = '"+str(filename)+"'")
                                cursor.execute(update_hgraph)
                                cnx.commit()
                            ###############

                            ###############
                            # delete all the types of hgs for update
                            cursor = cnx.cursor()
                            delete_hgraph_category = ("DELETE FROM hgraphs_categories WHERE hgraph_id = '"+str(myuuid)+"'")
                            cursor.execute(delete_hgraph_category)
                            cnx.commit()
                            ###############
                            # insert new categories
                            for category in categories[2:]:
                                if category == "":
                                    continue
                                else:
                                    # check if the category is already in the database
                                    search_category = ("SELECT * FROM categories WHERE type = '"+str(category)+"'")
                                    cursor = cnx.cursor()
                                    cursor.execute(search_category)
                                    result_category = cursor.fetchall()
                                    myuuid_category = ""
                                    if len(result_category) == 0:
                                        # if the category is not in the database, add it
                                        myuuid_category = uuid.uuid4()
                                        cursor = cnx.cursor()
                                        add_category = ("INSERT INTO categories (id, type)"
                                                        " VALUES ('"+str(myuuid_category)+"', '"+str(category)+"')")
                                        cursor.execute(add_category)
                                        cnx.commit()
                                    else:
                                        # if the category is in the database, get the id
                                        myuuid_category = result_category[0][0]

                                    # insert the category in the hgraph_categories table
                                    cursor = cnx.cursor()
                                    myuuid_hgraph_category = uuid.uuid4()
                                    add_hgraph_category = ("INSERT INTO hgraphs_categories (id, hgraph_id, category_id)"
                                                    " VALUES ('"+str(myuuid_hgraph_category)+"', '"+str(myuuid)+"', '"+str(myuuid_category)+"')")
                                    cursor.execute(add_hgraph_category)
                            ###############
                            

            ###############
            # updated_at update as the most recent file changed
            cursor = cnx.cursor()
            update_hgraph = ("UPDATE hgraphs SET updated_at = '"+str(new_date)+"' WHERE name = '"+str(filename)+"'")
            cursor.execute(update_hgraph)
            cnx.commit()

            ###############
            cnx.close()
                
