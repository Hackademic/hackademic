from lettuce import *
from lxml import html
from selenium import webdriver
import lettuce_webdriver.webdriver


@steps
class HackademicLoadingtest(object):
    """Test the loading of Hackademic"""

    def __init__(self, environs):
        world.browser = webdriver.Firefox()

HackademicLoadingtest(world)
