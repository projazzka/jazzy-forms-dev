from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
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
        self.driver.get(self.base_url + 'wptest/wp-login.php')
        self.driver.find_element_by_id("user_login").clear()
        self.driver.find_element_by_id("user_login").send_keys("admin")
        self.driver.find_element_by_id("user_pass").clear()
        self.driver.find_element_by_id("user_pass").send_keys("admin123")
        self.driver.find_element_by_id("wp-submit").click()

    def test_single_empty_form(self):
        driver = self.driver
        driver.find_element_by_css_selector("#toplevel_page_jzzf_forms_top img").click()
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("A new form")
        driver.find_element_by_id("jzzf_new_form_add").click()
        driver.find_element_by_id("jzzf_form_save").click()
        options = driver.find_elements_by_css_selector("#jzzf_selector option")
        self.assertEqual(len(options), 1)
        self.assertEqual('A new form', options[0].text)
        self.assertEqual('A new form', driver.find_element_by_id("jzzf_title").get_attribute('value'))

    def test_add_elements(self):
        driver = self.driver
        driver.find_element_by_css_selector("#toplevel_page_jzzf_forms_top img").click()
        driver.find_element_by_id("jzzf_new_form_title").clear()
        driver.find_element_by_id("jzzf_new_form_title").send_keys("Form1")
        driver.find_element_by_id("jzzf_new_form_add").click()
        driver.find_element_by_css_selector('li[jzzf_type="n"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="a"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="d"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="r"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="c"]').click()
        driver.find_element_by_css_selector('li[jzzf_type="f"]').click()
        driver.find_element_by_id("jzzf_form_save").click()
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
    
    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
