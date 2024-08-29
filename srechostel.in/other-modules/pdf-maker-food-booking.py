from xhtml2pdf import pisa
import os,sys
from datetime import datetime

date = datetime.now()

formatted_date = date.strftime("%B %d, %Y")

os.chdir('../files/food-booking/bills-pdf/')

def convert_html_to_pdf(html_string, pdf_path):
    with open(pdf_path, "wb") as pdf_file:
        pisa_status = pisa.CreatePDF(html_string, dest=pdf_file)
        
    return not pisa_status.err

pdf_path = sys.argv[1]+'.pdf'
total_people = sys.argv[2] 
total_cost = sys.argv[3] 
food_combo = sys.argv[4] 
event_date = sys.argv[5] 
event_name = sys.argv[6] 
html_content = f"""
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Food Order Bill Invoice</title>
<style>
    body {{
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }}

    .container {{
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }}

    .header {{
        text-align: center;
        margin-bottom: 20px;
    }}

    .header h1 {{
        color: #333;
        margin: 0;
    }}

    table {{
        width: 100%;
        border-collapse: collapse;
    }}

    table, th, td {{
        border: 1px solid #ddd;
    }}

    th, td {{
        padding: 10px;
        text-align: left;
    }}

    .total {{
        text-align: right;
        font-weight: bold;
    }}

    .footer {{
        margin-top: 20px;
        text-align: center;
        color: #777;
    }}
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Food Order Bill Invoice</h1>
            <p>Issued on: {formatted_date}</p>
        </div>
        <table>
            <tr>
                <th>Description</th>
                <th>Total Quantity</th>
                <th>Price(single entity)</th>
                <th>Total Amount</th>
            </tr>
            
            <tr>
                <td>Food Required</td>
                <td>{total_people}</td>
                <td>{int(total_cost)/int(total_people)}</td>
                <td>{int(total_cost)} Rs</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Final Amount</td>
                <td>{int(total_cost)} Rs</td>
            </tr>
        </table>
        <div class="footer">
            <p>Thank you for Ordering Food !</p>
        </div>
    </div>
</body>
</html>

"""



if convert_html_to_pdf(html_content, pdf_path):
    pass



