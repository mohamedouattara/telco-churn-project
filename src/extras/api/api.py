
# -*- coding: utf-8 -*-

from flask import Flask, request

app = Flask(__name__)

@app.route('/')
def hello_world():
    return 'Hello, World!'



@app.route('/prediction/', methods = ['POST'])
def prediction():
	response = dict()
	if request.method == 'POST':
		response['response'] = request.form['var']
		return response
	 