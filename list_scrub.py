#!/usr/bin/python
import sys, string, time, re, os, subprocess, MySQLdb, datetime, xlwt, smtplib,email,email.encoders,email.mime.text,email.mime.base
from email.mime.multipart import MIMEMultipart

now = datetime.datetime.now()
date = now.strftime("%Y-%m-%d")
filename = sys.argv[1]

#connect to database
db = MySQLdb.connect('localhost', 'cron', '1234', 'asterisk')
con = db.cursor()


splitArgv = sys.argv[2].split(" ")

if len(splitArgv) > 1:
	lists = []
	for list in sys.argv[2].split():
		lists.append(list)
	listIdString = str(tuple(lists))
else:
	listIdString = "( "+str(sys.argv[2])+" )"

linecount = 0
dncmatch = 0
#NON NUMERIC FILTER
non_decimal = re.compile(r'[^\d.]+')
for phone in open(filename,'r').readlines():
	phoneDigits = non_decimal.sub('', phone.strip())
	sql =  "SELECT lead_id FROM vicidial_list WHERE phone_number = '%s' AND list_id IN %s" % (phoneDigits, listIdString)
	print sql
	con.execute(sql)
	data = con.fetchall()
	linecount = linecount + 1
	for id in data:
		dncmatch = dncmatch + 1
		sql = "INSERT INTO vicidial_list_dnc SELECT * FROM vicidial_list WHERE lead_id = '%s'" % (id[0])
		print sql
		con.execute(sql)
		sql = "DELETE FROM vicidial_list WHERE lead_id = '%s'" % (id[0])
		print sql
		con.execute(sql)


smtpserver = 'localhost'
#to = ["jbernier@itsinc.co","joelshas@yahoo.com"]
to = ["joelshas@yahoo.com"]
fromAddr = 'scrub_report@itsinc.psinet.pw'
subject = "Scrub Report "+date

# create html email
html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" '
html +='"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">'
html +='<body style="font-size:12px;font-family:Verdana"><p>...</p>'
html +="Scrubbed the following lists : "+listIdString+"<br />"
html +="Total DNC matches : "+str(dncmatch)+"<br />"
html +="Total DNC records in source file : "+str(linecount)+"<br />"
html += "</body></html>"
emailMsg = email.MIMEMultipart.MIMEMultipart('mixed')
emailMsg['Subject'] = subject
emailMsg['From'] = fromAddr
emailMsg['To'] = ', '.join(to)
emailMsg.attach(email.mime.text.MIMEText(html,'html'))

# now attach the file
#fileMsg = email.mime.base.MIMEBase('application','vnd.ms-excel')
#fileMsg.set_payload(file(filename).read())
#email.encoders.encode_base64(fileMsg)
#fileMsg.add_header('Content-Disposition','attachment;filename='+filename)
#emailMsg.attach(fileMsg)

# send email
server = smtplib.SMTP(smtpserver)
server.sendmail(fromAddr,to,emailMsg.as_string())
server.quit()

