from twilio.rest import Client
import json
import sys

def parse_json(json_data):
    try:
        parsed_data = json.loads(json_data)
        return parsed_data
    except json.JSONDecodeError as e:
        print("Error: JSON decoding failed:", e)
        return None

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python json_parser.py <json_data>")
        sys.exit(1)

    json_data = +sys.argv[1]
    parsed_data = parse_json(json_data)
    if parsed_data:
        if isinstance(parsed_data, dict):  # Check if parsed_data is a dictionary
            for key, value in parsed_data.items():
                print(f"{key}: {value}")
        else:
            print("Parsed data is not a dictionary:", parsed_data)



# account_sid = 'AC0e5de8a45b92f2af6404dc5e2c150c21'
# auth_token = '5a9565635c806d6ddf879d0696b1e806'
# client = Client(account_sid, auth_token)

# message = client.messages.create(
#   from_='whatsapp:+14155238886',
#   body='Your appointment is coming up on July 21 at 3PM',
#   to='whatsapp:+919600944093'
# )

# print(message.sid)