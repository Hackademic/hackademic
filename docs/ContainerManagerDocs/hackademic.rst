Overview
========

As a part of this year `OWASP summer code sprint <https://www.owasp.org/index.php/Summer_Code_Sprint2015>`_ we have developed a container engine using docker with which we have a web sandbox for executing vulnerable piece of codes. Currently the challenges hosted in Hackademic aren’t really vulnerable and the solutions are checked using regular expressions. This severely limits the challenges the project can host and also as more complex challenges get introduced, checking for correct solutions of e.g. a mysql injection challenge is very hard using only regular expressions. Also, in this way the users can’t have helpful error messages to give them tips.

Hackademic is not supposed to be vulnerable itself but host other vulnerable applications. Therefore, a container engine could be build. The container engine could use virtualization solutions to host actually vulnerable applications or whole server setups. You can read the full proposal regarding the project `here <https://github.com/a0xnirudh/hackademic/wiki/Summer-Code-Sprint-Proposal>`_.

Here is the documentation on how to use the ContainerEngine properly and how can you add your own challenges to the engine.

.. note::
    Container Engine is still in its early stages and chances of finding bugs are high. If you came accross any bugs while using it, please don't hesitate to report us `here <https://github.com/Hackademic/hackademic/issues>`_.
