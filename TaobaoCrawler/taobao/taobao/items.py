# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class TaobaoItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
	uid = scrapy.Field()
	link = scrapy.Field()
	xxx = scrapy.Field()

	print "HAHAHAHAH: ", xxx
