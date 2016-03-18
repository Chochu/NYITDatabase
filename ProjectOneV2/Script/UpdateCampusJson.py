import json
import mysql.connector
import collections
def main():
    cnx = mysql.connector.connect(user='root', password='', host='127.0.0.1', database='nyit')
    cursor = cnx.cursor()
    comm = "SELECT * FROM nyit.campus;"
    cursor.execute(comm)
    result = cursor.fetchall()

# Convert query to objects of key-value pairs

    objects_list = []
    for row in result:
        d = collections.OrderedDict()
        d['id'] = row[0]
        d['Name'] = row[1]
        d['Abb'] = row[2]
        d['Address'] = row[3]
        d['State'] = row[4]
        d['Zip'] = row[5]
        d['Country'] = row[6]
        objects_list.append(d)

    j = json.dumps(objects_list)
    f = open("C:\wamp\www\ProjectOneV2\Script\JSON\campus.json",'w')
    #f2 = open("C:\wamp\www\ProjectOneV2\Script\JSON\campusJS.json",'w')
    f.write(j)
    #f2.write('data= \'' + j + '\';')
    cursor.close()
    cnx.close()

if __name__ == "__main__":
    main()
