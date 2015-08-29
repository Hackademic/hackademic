"""Class to deal with data sent from xml file

.. module:: data
    :platform: unix, windows
    :synopsis: reads the xml and stores required information in memory

.. moduleauthor:: Minhaz A V <minhazav@gmail.com>
"""
import xml.etree.ElementTree as ET


class vagrantFile:
    """Simple class to store src, dest, type information
    about the files
    """

    def __init__(self, src, dest, type):
        """Constructor
        Args:
            src (str): the source path of file in the host machine
            dest (str): the destination path of file in the VM
            type (str): **file** / **dir** suggesting weather its a file or directory respectively
        """
        self.src = src
        self.dest = dest
        self.isADir = (type == 'dir')


class vagrantData:
    """Class to read the challenge.xml and load the info to memory
    """
    
    baseBox = None
    puppetManifest = None
    flags = []
    files = []
    scripts = []
    modules = None

    def parse(self):
        """Method to parse the xml"""
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

            elif "modules" == child.tag:
                self.modules = child.text

        return True

    def __init__(self, filename):
        """Constructor

        Args:
            filename (str): the path of challenge.xml file
        """
        tree = ET.parse(filename)
        self.root = tree.getroot()
