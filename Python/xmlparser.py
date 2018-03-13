#!/usr/bin/env python3
""" # Python version = 3
	Parses the xml files and reports if correctly formatted or not with the format of the files in challenges folder.(check for both format : before ch010 and after that)
	Currently run through terminal/command prompt by specifying the relative file path and output on prompt.
	Can be extended for reporting non nullable fields errors.
	Can be easily integrated with the current system.
	
	To run on terminal:
		Go to the file folder in terminal/command prompt.
		Type python3 xmlparser.py
		Enter the file name.
	*    ----------------------------------------------------------------
				OWASP Hackademic Challenges Project
	*    ----------------------------------------------------------------
	*   	 Rohit Lodha     
	*    ----------------------------------------------------------------"""

import xml.etree.ElementTree as ET
import xml
def xmlparser(xmlfile):
	try:
		tree = ET.parse(xmlfile)							#Checking if file exist, if exist parse it and store it in tree
		try :
			root = tree.getroot()								#getting the root
			if (len(root)==6):									#For challenges with "level" and "duration" fields
				required_fields=["title","author","category","description","level","duration"]
				for field in required_fields:
					if (root.find(field)!=None):					#searching for every required field
						continue
					else :
						print("Incorrect formatting of required fields.")
						exit()
				print("Correctly formatted!")						
			elif (len(root)==4) :									#For challenges without "level" and "duration" fields
				required_fields=["title","author","category","description"]
				for field in required_fields:
					if (root.find(field)!=None):					#searching for every required field
						continue
					else :
						print("Incorrect formatting of required fields.")
						exit()
				print("Correctly formatted!")
			else :
				print("Incorrect formatting of necessary fields.")
		except ET.ParseError as Error:
			print(Error)										#prints the line no. on which error occured
	except FileNotFoundError:
		print("File Not Found.")
	except ET.ParseError as Error:
		print(Error)
		
if __name__=="__main__" :                                    #code to execute if called from command-line
	a = input("Enter File name relative to this file.\n")     #Taking file name input 
	xmlparser(a)												#calling xmlparser
