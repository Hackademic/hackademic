# Author Sanskar Modi
# github.com/sanskar-modi

from flask import Flask
from flask import request, make_response
from flask import render_template, render_template_string

app = Flask(__name__)

@app.route('/')
def xss():
	return render_template('xss.html') 

@app.route('/learn')
def learn():
	return render_template('learn.html')

@app.route('/demo')
def demo():
	return render_template('demo.html', name='<script>prompt(1);</script>')

@app.route('/demo/1')
def demo1():
	q = request.args.get('q', '')
	resp = make_response(render_template('demo1.html', q=q))
	resp.headers['X-XSS-Protection'] = 0
	return resp

@app.route('/demo/2')
def demo2():
	# Getting all message from cookie named chats
	# chats=Hi|I am god|I am flying
	chats = request.cookies.get('chats')
	msg = []
	if chats:
		messages = chats.split('|')
		for message in messages:
			msg.append(escape(message))
	else:
		chats = ''

	# Appending new message to list, if any
	new_msg = escape(request.args.get('msg', ''))
	if new_msg:
		msg.append(new_msg)
		# Adding new msg in cookie
		chats = '|'.join((chats, new_msg)) 

	resp = make_response(render_template('demo2.html', msg=msg))
	resp.set_cookie('chats', chats)
	return resp

# Escape filter for demo 2
# change script -> ''
def escape(str):
	return str.replace('script', '')

if __name__ == '__main__':
	app.run(debug=True)