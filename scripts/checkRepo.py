import mysql.connector
from mysql.connector import errorcode
import os
from os.path import dirname, abspath
# load environment variables
from dotenv import load_dotenv
load_dotenv()
import uuid


DB_U= os.getenv("DB_USERNAME")
DB_P= os.getenv("DB_PASSWORD")
DB_D= os.getenv("DB_DATABASE")

d = dirname(dirname(dirname(abspath(__file__))))
datasets = d + "/datasets"

for filename in os.listdir(datasets):
    f = os.path.join(datasets, filename)
    # checking if it is a directory and not a hidden directory
    if os.path.isdir(f) and not filename.startswith("."):
        for files in os.listdir(f):
            # inside each folder
            # print(files)
            if files.endswith(".md"):
                print("found md file")
                try:
                    cnx = mysql.connector.connect(user=DB_U, password=DB_P, database=DB_D)
                    # print first row of table hgraphs
                    cursor = cnx.cursor()
                    myuuid = uuid.uuid4()
                    created_at = "2020-10-10 10:10:10"
                    update_at = "2020-10-10 10:10:10"
                    add_hgraph= ("INSERT INTO hgraphs (id, name, category, created_at, updated_at)"
                        " VALUES ('"+str(myuuid)+"', '"+str(filename)+"', 'test', '"+str(created_at)+"', '"+str(update_at)+"')")    
                    cursor.execute(add_hgraph)
                    cnx.commit()
                    # local_path = datasets + "/" + filename + "/" + files
                    # read = open(local_path, 'r').read()
    
                    read = "storage/datasets/" + filename + "/info.md"
                    # update row with description
                    update_hgraph = ("UPDATE hgraphs SET description = '"+str(read)+"' WHERE id = '"+str(myuuid)+"'")
                    # add_hgraph_file = "LOAD DATA INFILE '"+local_path+"' INTO TABLE dhgs.hgraphs.description;"
                    cursor.execute(update_hgraph)
                    cnx.commit()

                    

                except mysql.connector.Error as err:
                    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                        print("Something is wrong with your user name or password")
                    elif err.errno == errorcode.ER_BAD_DB_ERROR:
                        print("Database does not exist")
                    else:
                        print(err)
                else:
                    cnx.close()