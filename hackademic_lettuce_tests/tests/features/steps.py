from lettuce import *
from lxml import html
from selenium import webdriver
import lettuce_webdriver.webdriver

baseurl = "http://localhost/hackademic/"


@steps
class HackademicLoadingtest(object):
    """Test the loading of Hackademic"""

    def __init__(self, environs):
        world.browser = webdriver.Firefox()

    def i_click_challenege(self, step, no):
        '''I click Challenge (\d+)'''
        world.no = no
        world.browser.find_element_by_link_text('Challenge ' + no).click()

    def i_click_on_challenge(self, step, text):
        '''I click "([^"]*)" on Challenge'''
        world.browser.find_element_by_link_text(text).click()
        world.browser.switch_to_window(world.browser.window_handles[1])

    def i_input_value_to_and_click(self, step, input_text, id):
        '''I input value "(.*)" and click "(.*)"'''
        ele = world.browser.find_element_by_name(id)
        ele.send_keys(input_text)
        world.browser.find_element_by_xpath("/html/body/center/font/h2/form/input[2]").click()
        world.browser.switch_to_alert().accept()
        world.browser.switch_to_window(world.browser.window_handles[1])

    def i_close_the_challenge(self, step):
        '''I close the Challenge'''
        world.browser.close()
        world.browser.switch_to_window(world.browser.window_handles[0])

HackademicLoadingtest(world)
