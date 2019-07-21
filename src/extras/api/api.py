
# -*- coding: utf-8 -*-

from flask import Flask, request
import json

app = Flask(__name__)

@app.route('/')
def hello_world():
	test = 1
	return 'Hello, World!'



@app.route('/prediction/', methods = ['POST'])
def prediction():
	response = dict()
	if request.method == 'POST':
		response['response'] = request.form['var']
		y = json.loads(request.form['var'])
		#print(y['prenom'])
		return y

