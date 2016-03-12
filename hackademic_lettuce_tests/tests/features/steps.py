from lettuce import *
from lxml import html
from selenium import webdriver
import lettuce_webdriver.webdriver
import time

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

    def i_reload_the_site(self, step):
        '''I reload the site'''
        world.browser.get(self.current_url)

    def i_set_user_agent_as(self, step, browser):
        '''I set user agent as "([^"]*)"'''
        self.current_url = world.browser.current_url
        world.browser.close()
        profile = webdriver.FirefoxProfile()
        profile.set_preference("general.useragent.override", browser)
        world.browser = webdriver.Firefox(profile)


HackademicLoadingtest(world)
