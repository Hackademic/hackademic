"""

:Synopsis: Specialized Class for implementing effective logging.
:Location: All logs are saved in the directory **hackademic-logs**.

"""

import os
import logging

__author__ = 'AnirudhAnand (a0xnirudh) <anirudh@init-labs.org>'


class LoggingManager:

    def __init__(self):
        self.path = os.getcwd()
        return

    def create_logger(self, name, filename):
        """
        This function defines a standard template which can be used to create
        additional logging classes in the future. Give a valid name and the
        filename to which the logs should be saved.

        :rtype:             ->       object
        :param  name:       ->       Name given to the logging process
        :param filename:    ->       Filename to which logs should be saved
        :return:            ->       A logger object that can be used to log
        """
        logger = logging.getLogger(name)
        logger.setLevel(logging.DEBUG)

        # create console handler and set level to debug
        ch = logging.FileHandler(filename=self.path + '/hackademic-logs/'+filename)
        ch.setLevel(logging.DEBUG)

        # create formatter - Format in which message is saved
        formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s')
        ch.setFormatter(formatter)

        # add ch to logger
        logger.addHandler(ch)

        return logger

    def install_log(self, exception=None):
        """
        All logs during the installation will be handled here.

        :param exception:   ->  Any additional logging Messages
        """
        logger = self.create_logger('install_log', 'install.logs')
        logger.exception(exception)
        return

    def container_runtime_log(self, exception=None):
        """
        All logs during the container runtime will be handled here.

        :param exception:   ->  Any additional logging Messages
        """
        logger = self.create_logger('container_runtime_log', 'container.logs')
        logger.exception(exception)
        return
