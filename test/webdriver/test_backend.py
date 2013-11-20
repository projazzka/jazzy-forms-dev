# -*- coding: utf-8 -*-

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.support.wait import WebDriverWait
import unittest, time, re

class Backend(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://blankito.local/workspace/wpbay/"
        self.reset_url = "http://blankito.local/workspace/jazzy-forms-dev/test/refdb/reset.php"
        self._reset();
        self._login();

    def _reset(self):
        self.driver.get(self.reset_url)
        self.driver.find_element_by_id('installed').click()
        self.driver.find_element_by_id('submit').click()
        
    def _login(self):
        driver = self.driver
        driver.get(self.base_url + 'wptest/wp-login.php')
        wait = WebDriverWait(self.driver, 10)
        wait.until(lambda driver: driver.find_element_by_id('wp-submit'))
        time.sleep(2)
        driver.find_element_by_id("user_login").clear()
        driver.find_element_by_id("user_login").send_keys("admin")
        driver.find_element_by_id("user_pass").clear()
        driver.find_element_by_id("user_pass").send_keys("admin123")
        driver.find_element_by_id("wp-submit").click()

    def test_single_empty_form(self):
        driver = self.driver
        self._jazzy()
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("A new form")
        driver.find_element_by_id("jzzf_form_save").click()
        self.assertEqual(driver.find_element_by_id('message').text, "Form Saved.")
        options = driver.find_elements_by_css_selector("#jzzf_selector option")
        self.assertEqual(len(options), 1)
        self.assertEqual('A new form', options[0].text)
        self.assertEqual('A new form', driver.find_element_by_id("jzzf_title").get_attribute('value'))

    def test_add_elements(self):
        driver = self.driver
        self._jazzy()
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("Form1")
        driver.find_element_by_css_selector('li[jzzf_type="n"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="a"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="d"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="r"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="c"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="f"]').click()
        driver.find_element_by_id("jzzf_form_save").click()
        self.assertEqual(driver.find_element_by_id('message').text, "Form Saved.")
        options = driver.find_elements_by_css_selector("#jzzf_selector option")
        self.assertEqual(len(options), 1)
        self.assertEqual('Form1', options[0].text)
        self.assertEqual('Form1', driver.find_element_by_id("jzzf_title").get_attribute('value'))
        elements = driver.find_elements_by_css_selector('#jzzf_elements_list input.jzzf_element_type')
        self.assertEqual('n', elements[0].get_attribute('value'))
        self.assertEqual('a', elements[1].get_attribute('value'))
        self.assertEqual('d', elements[2].get_attribute('value'))
        self.assertEqual('r', elements[3].get_attribute('value'))
        self.assertEqual('c', elements[4].get_attribute('value'))
        self.assertEqual('f', elements[5].get_attribute('value'))

    def test_two_forms(self):
        driver = self.driver
        self._jazzy()
        
        # save 1st form
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("1 form")
        driver.find_element_by_css_selector('li[jzzf_type="n"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="a"]').click()
        driver.find_element_by_id("jzzf_form_save").click()
        
        # save 2nd form 
        driver.find_element_by_id("jzzf_selector_new").click()
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("2 form")
        driver.find_element_by_css_selector('li[jzzf_type="d"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="r"]').click()
        driver.find_element_by_id("jzzf_form_save").click()
        
        # check form selector
        options = driver.find_elements_by_css_selector("#jzzf_selector option")
        self.assertEqual(len(options), 2)
        self.assertEqual('1 form', options[0].text)
        self.assertEqual('2 form', options[1].text)
        selected = driver.find_element_by_css_selector('#jzzf_selector option[selected="selected"]')
        self.assertEqual('2 form', selected.text)
        
        # check 2nd form's elements
        self.assertEqual('2 form', driver.find_element_by_id("jzzf_title").get_attribute('value'))
        elements = driver.find_elements_by_css_selector('#jzzf_elements_list input.jzzf_element_type')
        self.assertEqual('d', elements[0].get_attribute('value'))
        self.assertEqual('r', elements[1].get_attribute('value'))
        
        # check 1st form's elements
        Select(driver.find_element_by_id('jzzf_selector')).select_by_index(0)
        self.assertEqual('1 form', driver.find_element_by_id("jzzf_title").get_attribute('value'))
        elements = driver.find_elements_by_css_selector('#jzzf_elements_list input.jzzf_element_type')
        self.assertEqual('n', elements[0].get_attribute('value'))
        self.assertEqual('a', elements[1].get_attribute('value'))
        
    def test_clone_form(self):
        self._jazzy()
        
        # original form
        self._add_form("1st form")
        self._add_element("n")
        self._add_element("a")
        self._add_element("e") # email
        self._edit_element(0, "title", "Titulus")
        self._select_tab("email")
        self._edit_form("email_to", "michael@jacksons.com")
        self._edit_form("email_message", "Hello,\nGood Bye")
        self._save_form()
        
        # clone form
        self.driver.find_element_by_id("jzzf_selector_clone").click()
        
        # suggested title
        self.assertTrue(self.driver.find_element_by_id('jzzf_new_form_title').is_displayed());
        self.assertEqual('1st form 2', self.driver.find_element_by_id('jzzf_new_form_title').get_attribute('value'))
        
        # edit form
        self._toggle_element(0)
        self._edit_element(0, "title", "Titulus Tituli")
        self._select_tab("email")
        self._edit_form("email_message", "Brand new form!")
        self._save_form()

        # check cloned form's elements
        self._assert_form_attribute('title', '1st form 2')
        self._assert_element_attribute(0, 'type', 'n')
        self._assert_element_attribute(1, 'type', 'a')
        self._assert_element_attribute(2, 'type', 'e')
        self._assert_form_attribute("email_to", "michael@jacksons.com")
        self._assert_form_attribute("email_message", "Brand new form!")
        self._toggle_element(0)
        self._assert_element_attribute(0, 'title', 'Titulus Tituli')
        
        # check 1st form's elements
        Select(self.driver.find_element_by_id('jzzf_selector')).select_by_index(0)
        self._assert_form_attribute('title', '1st form')
        self._assert_element_attribute(0, 'type', 'n')
        self._assert_element_attribute(1, 'type', 'a')
        self._assert_form_attribute("email_to", "michael@jacksons.com")
        self._assert_form_attribute("email_message", "Hello,\nGood Bye")
        self._toggle_element(0)
        self._assert_element_attribute(0, 'title', 'Titulus')
 
    def test_clone_element(self):
        self._jazzy()
        
        self._add_form("My Form")
        self._add_element('n')
        self._edit_element(0, "title", "Number Element")
        self._edit_element(0, "name", "number_element")
        self.driver.find_element_by_css_selector("#jzzf_elements_list > li:first-child .jzzf_element_clone").click()
        self._assert_element_attribute(1, 'type', 'n')
        self._assert_element_attribute(1, 'title', 'Number Element 2')
        self._assert_element_attribute(1, 'name', 'number_element_2')

        self._save_form()
        self._assert_element_attribute(0, 'type', 'n')
        self._assert_element_attribute(0, 'title', 'Number Element')
        self._assert_element_attribute(0, 'name', 'number_element')
        self._assert_element_attribute(1, 'type', 'n')
        self._assert_element_attribute(1, 'title', 'Number Element 2')
        self._assert_element_attribute(1, 'name', 'number_element_2')
        self._toggle_element(1)
        self._edit_element(1, "title", "New Number Element")

        self._save_form()
        self._assert_element_attribute(0, 'title', 'Number Element')
        self._assert_element_attribute(1, 'title', 'New Number Element')
        self._assert_element_attribute(1, 'name', 'number_element_2')

    def test_options(self):
        self._jazzy()
        
        self._add_form("Form")
        self._add_element('r')
        self._assert_option(0, 0, 'Option', '', True)
        self._assert_option_count(0, 1)
        self._add_option(0)
        self._assert_option(0, 1, 'Option', '', False)
        self._edit_option(0, 0, 'Eins', '10')
        self._edit_option(0, 1, 'Zwei', '20')
        self._assert_option_count(0, 2)
        self._add_option(0)
        self._edit_option(0, 2, 'Drei', '30')
        self._assert_option(0, 0, 'Eins', '10', True)
        self._assert_option(0, 1, 'Zwei', '20', False)
        self._assert_option(0, 2, 'Drei', '30', False)
        self._assert_option_count(0, 3)
        self._select_option(0, 1)
        self._assert_option(0, 0, 'Eins', '10', False)
        self._assert_option(0, 1, 'Zwei', '20', True)
        self._delete_option(0, 1)
        self._assert_option(0, 0, 'Eins', '10', True)
        self._assert_option(0, 1, 'Drei', '30', False)
        self._assert_option_count(0, 2)

        self._save_form()
        self._assert_option(0, 0, 'Eins', '10', True)
        self._assert_option(0, 1, 'Drei', '30', False)
        
    def test_clone_options(self):
        self._jazzy()
        
        self._add_form("Form")

        self._add_element('d')
        self._assert_option(0, 0, 'Option', '', True)
        self._assert_option_count(0, 1)
        self._add_option(0)
        self._assert_option(0, 1, 'Option', '', False)
        self._edit_option(0, 0, 'Eins', '10')
        self._edit_option(0, 1, 'Zwei', '20')
        self._select_option(0, 1)
        self._assert_option(0, 0, 'Eins', '10', False)
        self._assert_option(0, 1, 'Zwei', '20', True)
        self._assert_option_count(0, 2)

        self.driver.find_element_by_css_selector("#jzzf_elements_list > li:first-child .jzzf_element_clone").click()
        self._assert_option(1, 0, 'Eins', '10', False)
        self._assert_option(1, 1, 'Zwei', '20', True)
        self._assert_option_count(0, 2)

        self._save_form()
        self._assert_option(0, 0, 'Eins', '10', False)
        self._assert_option(0, 1, 'Zwei', '20', True)
        self._assert_option_count(0, 2)
        self._assert_option(1, 0, 'Eins', '10', False)
        self._assert_option(1, 1, 'Zwei', '20', True)
        self._assert_option_count(0, 2)

        self._toggle_element(0)
        self._edit_option(0, 0, 'A', '1')
        self._edit_option(0, 1, 'B', '2')
        self._toggle_element(1)
        self._edit_option(1, 0, 'C', '3')
        self._edit_option(1, 1, 'D', '4')
        self._save_form()
               
        self._assert_option(0, 0, 'A', '1', False)
        self._assert_option(0, 1, 'B', '2', True)
        self._assert_option(1, 0, 'C', '3', False)
        self._assert_option(1, 1, 'D', '4', True)

    def test_smartid_special_chars(self):
        self._jazzy()
        
        self._add_form("Form")

        self._add_element('n')
        self._edit_element(0, "title", ' Der "$ber-Namensgebungs" {%titel%}')
        self._assert_element_attribute(0, 'name', '_der_bernamensgebungs_titel')

    def test_smartid_identical(self):
        self._jazzy()
        
        self._add_form("Form")

        self._add_element('n')
        self._add_element('n')
        self._add_element('n')
        self._edit_element(0, "title", "Identical")
        self._assert_element_attribute(0, 'name', 'identical')
        self._edit_element(1, "title", "Identical")
        self._edit_element(2, "title", "Identical")
        self._assert_element_attribute(0, 'name', 'identical')
        self._assert_element_attribute(1, 'name', 'identical_1')
        self._assert_element_attribute(2, 'name', 'identical_2')
                
    def _add_form(self, title, first=True):
        if not first:
            self.driver.find_element_by_id("jzzf_form_new").click()
        self.driver.find_element_by_id("jzzf_new_form_title").clear()
        self.driver.find_element_by_id("jzzf_new_form_title").send_keys(title)

    def _save_form(self):
        self.driver.find_element_by_id("jzzf_form_save").click()

    def _add_element(self, type):
        self.driver.find_element_by_css_selector('li[jzzf_type="{0}"]'.format(type)).click()
    
    def _edit_element(self, index, field, data):
        field = self.driver.find_element_by_css_selector("#jzzf_elements_list > li:nth-child({0}) .jzzf_element_{1}".format(index+1, field))
        field.clear()
        field.send_keys(data)

    def _toggle_element(self, index):
        self.driver.find_element_by_css_selector("#jzzf_elements_list > li:nth-child({0}) .jzzf_element_header".format(index+1)).click()

    def _assert_form_attribute(self, type, value):
        self.assertEqual(value, self.driver.find_element_by_id("jzzf_{0}".format(type)).get_attribute('value'))

    def _assert_element_attribute(self, index, type, value):
        field = self.driver.find_element_by_css_selector('#jzzf_elements_list > li:nth-child({0}) .jzzf_element_{1}'.format(index+1, type))
        self.assertEqual(value, field.get_attribute('value'))

    def _select_tab(self, type):
        self.driver.find_element_by_css_selector("#jzzf_tabs > li[jzzf_section=\"{0}\"]".format(type)).click()

    def _edit_form(self, type, value):
        field = self.driver.find_element_by_id("jzzf_{0}".format(type))
        field.clear()
        field.send_keys(value)
        
    def _edit_option(self, element, option, label, value):
        row = ".jzzf_element:nth-child({0}) .jzzf_option:nth-child({1})".format(element+1, option+1)
        label_element = self.driver.find_element_by_css_selector(row + ' .jzzf_option_title')
        label_element.clear()
        label_element.send_keys(label)
        value_element = self.driver.find_element_by_css_selector(row + ' .jzzf_option_value')
        value_element.clear()
        value_element.send_keys(value)

    def _assert_option(self, element, option, label, value, default):
        row = ".jzzf_element:nth-child({0}) .jzzf_option:nth-child({1})".format(element+1, option+1)
        self.assertEqual(self.driver.find_element_by_css_selector(row + ' .jzzf_option_title').get_attribute('value'), label)
        self.assertEqual(self.driver.find_element_by_css_selector(row + ' .jzzf_option_value').get_attribute('value'), value)
        self.assertEqual(self.driver.find_element_by_css_selector(row + ' .jzzf_option_default').is_selected(), default)

    def _assert_option_count(self, element, number):
        options = self.driver.find_elements_by_css_selector(".jzzf_element:nth-child({0}) .jzzf_option".format(element+1))
        self.assertEqual(len(options), number)
        
    def _add_option(self, element):
        self.driver.find_element_by_css_selector("#jzzf_elements_list > li:nth-child({0}) .jzzf_option_add".format(element+1)).click()
        
    def _select_option(self, element, option):
        self.driver.find_element_by_css_selector(".jzzf_element:nth-child({0}) .jzzf_option:nth-child({1}) .jzzf_option_default"
            .format(element+1, option+1)).click()

    def _delete_option(self, element, option):
        self.driver.find_element_by_css_selector(".jzzf_element:nth-child({0}) .jzzf_option:nth-child({1}) .jzzf_option_delete"
            .format(element+1, option+1)).click()
        self.driver.switch_to_alert().accept();
        
    def _jazzy(self):
        """Go to Jazzy Forms main screen"""
        self.driver.find_element_by_css_selector("#toplevel_page_jzzf_forms_top a").click()

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
