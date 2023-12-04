import mysql.connector
from mysql.connector import errorcode
import os
# load environment variables
from dotenv import load_dotenv
load_dotenv()

DB_U= os.getenv("DB_USERNAME")
DB_P= os.getenv("DB_PASSWORD")
DB_D= os.getenv("DB_DATABASE")

try:
  cnx = mysql.connector.connect(user=DB_U, password=DB_P, database=DB_D)
  # print first row of table hgraphs
  cursor = cnx.cursor()
  cursor.execute("SHOW columns FROM hgraphs")
  print([column[0] for column in cursor.fetchall()])

  for i in range(5):
    add_hgraph_test = (" INSERT INTO hgraphs (id, name, category)"
        " VALUES ('"+str(i)+"', 'xname', 'xcategory')")    
    cursor.execute(add_hgraph_test)
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