#!/bin/python

import re
import os

class Log_Analyzer:
    def __init__(self, path):
        self.log_path = path

    def clear(self):
        try:
            os.remove(self.log_path)
        except:
            pass
        
    def get_lines(self):
        with open(self.log_path) as f:
            lines = f.readlines()
        return lines

    def get_subsequent(self, lines):
        result = ''
        for line in lines:
            match = re.match("\[[^\]]*\]->", line)
            if match is None:
                break
            result += "\n" + line[match.end():-1]
        return result

    def extract(self, pattern):
        result = None
        lines = self.get_lines()
        for idx, line in enumerate(lines):
            match = re.search(pattern, line)
            if match is not None:
                result = line[match.end():-1]
                result += self.get_subsequent(lines[idx+1:])
        return result
