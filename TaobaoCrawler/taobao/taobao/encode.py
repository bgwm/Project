with open("./maybeCorrect.html",'rw+') as f:
	#print unicode(f.read()).encode('utf-8')
	lines = f.read()
	for word in lines:
		unicode(word).encode('utf-8')
	print lines
	f.close()
