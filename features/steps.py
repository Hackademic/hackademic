from lettuce import *
from nose.tools import assert_equals
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

@step(u'Given I am logged in as "([^"]*)" with password "([^"]*)"')
def Given_i_am_logged_in_as_admin(step, username, password):
    world.response = world.browser.visit("http://localhost/hackademic/admin/")
    if(world.browser.title == "Hackademic CMS"):
        return True #already logged in

    world.browser.fill("username", username)
    world.browser.fill("pwd", password)
    world.browser.find_by_name("submit").first.click()

@step(u'And I enter "([^"]*)" into the "([^"]*)" field')
def and_i_enter_value_into_the_name_field(step, value, name):
    if(world.browser.find_by_name(name).first.visible):
        world.browser.fill(name, value)

@step(u'And I enter "([^"]*)" into the "([^"]*)" tinymce')
def and_i_enter_value_into_the_name_tinymce(step, value, id):
    js_String = 'tinymce.get(\'{}\').setContent(\'{}\')'.format(id, value)
    world.browser.execute_script( js_String )

@step(u'And I click on "([^"]*)" button')
def and_i_click_on_name_button(step, name):
    world.browser.find_by_name(name).first.click()

@step(u'And I click on "([^"]*)" link')
def and_i_click_on_name_link(step, text):
   world.browser.click_link_by_text(text)

@step(u'And I select "([^"]*)" from the "([^"]*)" field')
def and_i_select_value_from_the_name_field(step, value, name):
     world.browser.choose(name, value)

@step(u'Then I see the user success message "([^"]*)"')
def then_i_see_the_user_success_message(step, message):
   assert_equals(world.browser.find_by_css('.successmsg').first.value, message)

@step(u'Then I see the user error message "([^"]*)"')
def then_i_see_the_user_success_message(step, message):
   assert_equals(world.browser.find_by_css('.errormsg').first.value, message)

    



