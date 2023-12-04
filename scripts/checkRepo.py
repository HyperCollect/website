import mysql.connector
from mysql.connector import errorcode
import os
from os.path import dirname, abspath
# load environment variables
from dotenv import load_dotenv
load_dotenv()
import uuid
import requests

DB_U= os.getenv("DB_USERNAME")
DB_P= os.getenv("DB_PASSWORD")
DB_D= os.getenv("DB_DATABASE")
GIT_U= os.getenv("GIT_USERNAME")
GIT_T= os.getenv("GIT_TOKEN")

# repo in same root
# d = dirname(dirname(dirname(abspath(__file__))))
# datasets = d + "/datasets"

d = dirname(dirname(abspath(__file__)))
datasets = d + "/storage/app/public/datasets"
# print(d)

for filename in os.listdir(datasets):
    f = os.path.join(datasets, filename)
    # checking if it is a directory and not a hidden directory
    if os.path.isdir(f) and not filename.startswith("."):
        for files in os.listdir(f):
            # inside each folder | file.hg fild.md       
            if files.endswith(".md"):
                try:
                    apiCall = "https://api.github.com/repos/HyperCollect/datasets/commits?path=" + filename + "/info.md"
                    response = requests.get(apiCall, auth=(GIT_U, GIT_T))
                    res = response.json()
                    cnx = mysql.connector.connect(user=DB_U, password=DB_P, database=DB_D)
                    # sql query to search for the name of the folder
                    search_hgraph = ("SELECT * FROM hgraphs WHERE name = '"+str(filename)+"'")
                    cursor = cnx.cursor()
                    cursor.execute(search_hgraph)
                    result = cursor.fetchall()
                    if len(result) == 0:
                        # if the folder name is not in the database, add it
                        myuuid = uuid.uuid4()
                        res = response.json()
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

                        descr = "storage/datasets/" + filename + "/info.md"
                        # url = "https://github.com/HyperCollect/datasets" + filename + "/" + filename + ".hg"
                        url = "http://127.0.0.1:8000/download/" + filename
                        add_hgraph= ("INSERT INTO hgraphs (id, name, author, url, category, description, created_at, updated_at)"
                            " VALUES ('"+str(myuuid)+"', '"+str(filename)+"','" + author + "','" + url +"', 'test','" + str(descr) + "','"+str(created_at)+"', '"+str(update_at)+"')")    
                        cursor.execute(add_hgraph)
                        cnx.commit()
                    else:
                        # last commit on the file
                        res = res[0]
                        author = res['commit']['author']['name']
                        date = res['commit']['author']['date']
                        # format date
                        date = date.replace("T", " ")
                        date = date.replace("Z", "")

                        # check if the date is different
                        db_row_UpdatedAt = len(result[0])-1
                        db_row_createdAt = len(result[0])-2

                        if str(result[0][db_row_UpdatedAt]) != str(date):
                            # i have to update all the data
                            cursor = cnx.cursor()
                            update_hgraph = ("UPDATE hgraphs SET updated_at = '"+str(date)+"' WHERE name = '"+str(filename)+"'")
                            cursor.execute(update_hgraph)
                            cnx.commit()

                            ## update all the data
                            ## script.sh
                            ## end script.sh

                    # print first row of table hgraphs
                    # cursor = cnx.cursor()
                    # update_hgraph = ("UPDATE hgraphs SET description = '"+str(read)+"' WHERE id = '"+str(myuuid)+"'")
                    # cursor.execute(update_hgraph)
                    # cnx.commit()
                    

                except mysql.connector.Error as err:
                    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                        print("Something is wrong with your user name or password")
                    elif err.errno == errorcode.ER_BAD_DB_ERROR:
                        print("Database does not exist")
                    else:
                        print(err)
                else:
                    cnx.close()