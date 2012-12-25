from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.support.wait import WebDriverWait
from ConfigParser import ConfigParser
import unittest, time, re

class Js(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(5)
        self.cfg = ConfigParser()
        self.cfg.read('../config.ini')
        self.url_root = self.cfg.get('JS_TEST', 'URL_ROOT')

    def tearDown(self):
        self.driver.quit()

    def _load(self, name):
        self.driver.get('{0}{1}.html'.format(self.url_root, name))
        self.assertGreater(len(self.driver.find_elements_by_css_selector('#qunit-tests .pass')), 1)
        self.assertEqual(len(self.driver.find_elements_by_css_selector('#qunit-tests .fail')), 0)
        
    def test_cache(self):
        self._load('cache')
        
    def test_calculator(self):
        self._load('calculator')
        
    def test_conversion(self):
        self._load('conversion')

    def test_format(self):
        self._load('format')

    def test_functions(self):
        self._load('functions')

    def test_operations(self):
        self._load('operations')
        driver = self.driver

if __name__ == "__main__":
    unittest.main()
