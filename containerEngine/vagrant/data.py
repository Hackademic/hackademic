"""
Code to deal with data sent from xml file
@class vagrantData recieves the xml file path as param
loads it, and retrieve data from it.

#TODO - add error handling for all cases
"""
import xml.etree.ElementTree as ET


class vagrantFile:

    def __init__(self, src, dest, type):
        self.src = src
        self.dest = dest
        self.isADir = (type == 'dir')


class vagrantData:
    baseBox = None
    puppetManifest = None
    flags = []
    files = []
    scripts = []

    def parse(self):
        for child in self.root:
            if "basebox" == child.tag:
                self.baseBox = child.text

            elif "puppet" == child.tag:
                self.puppetManifest = child.text

            elif "files" == child.tag:
                self.files = []
                if len(child) > 0:
                    for grandchild in child:
                        try:
                            attribs = grandchild.attrib
                            self.files.append(
                                vagrantFile(
                                    attribs['src'],
                                    attribs['dest'],
                                    attribs['type']
                                )
                            )
                        except Exception as ex:
                            # TODO - get proper error message
                            return ex

            elif "flags" == child.tag:
                self.flags = []
                if len(child) > 0:
                    for grandchild in child:
                        self.flags.append(grandchild.text)
            elif "scripts" == child.tag:
                self.scripts = []
                if len(child) > 0:
                    for grandchild in child:
                        self.scripts.append(grandchild.text)
        return True

    def __init__(self, filename):
        tree = ET.parse(filename)
        self.root = tree.getroot()
