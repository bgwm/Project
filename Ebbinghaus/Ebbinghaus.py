import datetime

'For Programming Code Review'
print(filter(lambda y:
	y>0, 
	map(lambda x:
		(datetime.date.today() - datetime.date(2015,10,8)).days - x, 
		[0,1,3,7,14,29,59,119.239])
     )
)

	
