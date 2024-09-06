from twilio.rest import Client
import json
import sys
from datetime import datetime
import pytz

indian_tz = pytz.timezone('Asia/Kolkata')
indian_time = datetime.now(indian_tz)
indian_time_12h = indian_time.strftime('%I:%M:%S %p')
inputs = sys.argv[1].replace("'",'"')
inputs = inputs.replace("+"," ")
inputs = inputs.replace("%26","&")
json_data = json.loads(inputs)
name = json_data['name']
department = json_data['department']
rollNo =  json_data['rollNo']
year = json_data['studyYear']
passType = json_data['passType']
typeis = json_data['type']
account_sid = 'AC0e5de8a45b92f2af6404dc5e2c150c21'
auth_token = '5a9565635c806d6ddf879d0696b1e806'
client = Client(account_sid, auth_token)

message = client.messages.create(
body=">>>\n\t\t\t\t\t\t\t\t\t\t"+typeis+"\n---------------------------------------\nName : "+name+"\nRoll No : "+str(rollNo)+"\nDepartment : "+department+"\nStudy Year : "+str(year)+"\nPass Type : "+passType+"\nTime : "+indian_time_12h+"\n<<<",
from_='+12563841330',
to='+919600944093'
)
print("success")
