from lettuce import *
from nose.tools import assert_equals
from flask import Flask
from splinter import Browser


@before.all
def initial_setup():
    world.browser = Browser()

@after.all
def teardown_browser(total):
    world.browser.quit()

@step(u'When I access the url "([^"]*)"')
@step(u'Given I access the url "([^"]*)"')
def when_i_access_the_url(step, url):
    world.response = world.browser.visit(url)

@step(u'Then I see the header "([^"]*)"')
def then_i_see_the_header(step, title):
    assert_equals(world.browser.title,title)

@step(u'And I enter "([^"]*)" into the "([^"]*)" field')
def and_i_enter_value_into_the_name_field(step, value, name):
    if(world.browser.find_by_name(name).first.visible):
        world.browser.type(name, value)

@step(u'And I enter "([^"]*)" into the "([^"]*)" tinymce')
def and_i_enter_value_into_the_name_tinymce(step, value, id):
    js_String = 'tinymce.get(\'{}\').setContent(\'{}\')'.format(id, value)
    world.browser.execute_script( js_String )

@step(u'And I click on "([^"]*)" button')
def and_i_click_on_name_button(step, name):
    world.browser.find_by_name(name).first.click()

@step(u'And I select "([^"]*)" from the "([^"]*)" field')
def and_i_select_value_from_the_name_field(step, value, name):
     world.browser.choose(name, value)

@step(u'Then I see the user success message "([^"]*)"')
def then_i_see_the_user_success_message(step, message):
   assert_equals(world.browser.find_by_css('.successmsg').first.value, message)

