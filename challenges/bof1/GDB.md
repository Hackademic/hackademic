# GDB Tutorial
---

This is an first of the tutorials in the **Introduction to binary exploitation** tutorial series.

One of the few basic things you require while debugging a program is a debugger.

### What exactly is a debugger?

A debugger is a program that runs other programs, allowing the user to exercise control over these programs, and to examine variables when problems arise. GNU Debugger, which is also called ***gdb***, is the most popular debugger for UNIX systems to debug C and C++ programs.


In this tutorial, we will be looking at how to debug some simple programs with gdb and some of the basic commands are more frequently used by me while debugging.

So let's get started.

(Note: If you don't have gdb installed, check out this [this](ftp://ftp.gnu.org/old-gnu/Manuals/gdb/html_chapter/gdb_27.html) link. For Ubnutu users, simple `[sudo] apt-get install gdb` also works.)



## First program

```
#include <stdio.h>
#include <stdlib.h>

void print_message()
{
   printf("This is the print_message function!\nYou are welcome here!");
}

int main()
{
   int a = 5;
   int b = 7;
   int c = 3;
   int d = 1;
   
   int res = a*c;
   res-=d;
   res/=b;

   printf("%d\n", res);

   print_message();  
}
```

#### Compile this program:
`gcc -m32 -o prog1 prog1.c`

**-m32**: Flag used to generate 32-bit binary.
 
### Debug using GDB:

##### Useful Commands:

`break or b`:

**Usage:**

After running gdb, you can use this command to set breakpoints.

For eg. If you want to set up a breakpoint at the `main` function of the prog1 file, run:
```
(gdb) b main
Breakpoint 1 at 0x8048442
```

(Note: the address of the breakpoint may vary in your machine).

This sets up a break point at the main instruction.

To see a list of current break-points:

**use:** 

`info b`

```
(gdb) info b
Num     Type           Disp Enb Address    What
1       breakpoint     keep y   0x08048442 <main+14>

```

To delete a breakpoint:

`del <breakpoint number>`

```
(gdb) del 1
```


`run or r`:

This command starts the execution of the program. It will pause at the first breakpoint (if set) of the program.

```
(gdb) r
Starting program: /tmp/prog1

Breakpoint 1, 0x08048442 in main ()
```

`continue or c`:

This command continues the execution of the program until it finds the next break point.

For eg. In this case, we set up the second break-point at the `print_message` function, and then run the `continue` command:

```
(gdb) b print_message 
Breakpoint 2 at 0x8048421
(gdb) c
Continuing.
2

Breakpoint 2, 0x08048421 in print_message ()
```


**Automatic Display**

`display/fmt <expression/addr/register>`

Automatic display prints its value each time gdb stops. Can be used to print the value of expressions, addresses and registers each time the program stops.

```
(gdb) display/10i $eip
1: x/10i $eip
=> 0x8048442 <main+14>: sub    esp,0x24
   0x8048445 <main+17>: mov    DWORD PTR [ebp-0x1c],0x5
   0x804844c <main+24>: mov    DWORD PTR [ebp-0x18],0x7
   0x8048453 <main+31>: mov    DWORD PTR [ebp-0x14],0x3
   0x804845a <main+38>: mov    DWORD PTR [ebp-0x10],0x1
   0x8048461 <main+45>: mov    eax,DWORD PTR [ebp-0x1c]
   0x8048464 <main+48>: imul   eax,DWORD PTR [ebp-0x14]
   0x8048468 <main+52>: mov    DWORD PTR [ebp-0xc],eax
   0x804846b <main+55>: mov    eax,DWORD PTR [ebp-0x10]
   0x804846e <main+58>: sub    DWORD PTR [ebp-0xc],eax
```

**Display**:

`x/fmt addr`

Used to examine memory at different addresses. Even this can be used to print the value of expressions, addresses and registers. But it doesn't do it each time the program stops. We have to give this command each time we want to check that value.

eg. This instruction  used to view the stack.
```
(gdb) x/32xw $esp
0xffffd674: 0xffffd690  0x00000000  0xf7e1072e  0x00000000
0xffffd684: 0x08048320  0x00000000  0xf7e1072e  0x00000001
0xffffd694: 0xffffd724  0xffffd72c  0x00000000  0x00000000
0xffffd6a4: 0x00000000  0xf7fef049  0x0804821c  0x0804a014
0xffffd6b4: 0xf7fac000  0x00000000  0x08048320  0x00000000
0xffffd6c4: 0x7777adb4  0x4ad769a4  0x00000000  0x00000000
0xffffd6d4: 0x00000000  0x00000001  0x08048320  0x00000000
0xffffd6e4: 0xf7fee760  0xf7e10659  0xf7ffd000  0x00000001

```

`nexti or ni`:

Execute one machine instruction, but if it is a function call, proceed until the function returns.

`stepi or si`:

Execute one machine instruction, then stop and return to the debugger. It is often useful to do `display/i $eip` when stepping by machine instructions. This makes GDB automatically display the next instruction to be executed, each time your program stops.

To check out the difference between `nexti` and `stepi`, let's start a new debugging session.

(Note: Because I prefer Intel Syntax, I used the command `set disassembly-flavor intel`. But this choice is completely personal. Use the one you find yourself more comfortable with :) )

```
(gdb) set disassembly-flavor intel
(gdb) b main
Breakpoint 1 at 0x8048442
(gdb) display/10i $eip
1: x/10i $eip
<error: No registers.>
(gdb) r
Starting program: /tmp/prog1 

Breakpoint 1, 0x08048442 in main ()
1: x/10i $eip
=> 0x8048442 <main+14>: sub    esp,0x24
   0x8048445 <main+17>: mov    DWORD PTR [ebp-0x1c],0x5
   0x804844c <main+24>: mov    DWORD PTR [ebp-0x18],0x7
   0x8048453 <main+31>: mov    DWORD PTR [ebp-0x14],0x3
   0x804845a <main+38>: mov    DWORD PTR [ebp-0x10],0x1
   0x8048461 <main+45>: mov    eax,DWORD PTR [ebp-0x1c]
   0x8048464 <main+48>: imul   eax,DWORD PTR [ebp-0x14]
   0x8048468 <main+52>: mov    DWORD PTR [ebp-0xc],eax
   0x804846b <main+55>: mov    eax,DWORD PTR [ebp-0x10]
   0x804846e <main+58>: sub    DWORD PTR [ebp-0xc],eax

```

Now, step until the point where `print_message` is called.

```
(gdb) 
0x0804848e in main ()
1: x/10i $eip
=> 0x804848e <main+90>: call   0x804841b <print_message>
   0x8048493 <main+95>: mov    eax,0x0
   0x8048498 <main+100>:   mov    ecx,DWORD PTR [ebp-0x4]
   0x804849b <main+103>:   leave  
   0x804849c <main+104>:   lea    esp,[ecx-0x4]
   0x804849f <main+107>:   ret    
   0x80484a0 <__libc_csu_init>:  push   ebp
   0x80484a1 <__libc_csu_init+1>:   push   edi
   0x80484a2 <__libc_csu_init+2>:   xor    edi,edi
   0x80484a4 <__libc_csu_init+4>:   push   esi
   ```



Set a breakpoint at this address.
Now, use `nexti` to jump to next instruction.
You will observe that the instruction pointer jumps to the next instruction after the `call`

```
(gdb) b *0x804848e
Breakpoint 2 at 0x804848e
(gdb) ni
This is the print_message function!
0x08048493 in main ()
1: x/10i $eip
=> 0x8048493 <main+95>: mov    eax,0x0
   0x8048498 <main+100>:   mov    ecx,DWORD PTR [ebp-0x4]
   0x804849b <main+103>:   leave  
   0x804849c <main+104>:   lea    esp,[ecx-0x4]
   0x804849f <main+107>:   ret    
   0x80484a0 <__libc_csu_init>:  push   ebp
   0x80484a1 <__libc_csu_init+1>:   push   edi
   0x80484a2 <__libc_csu_init+2>:   xor    edi,edi
   0x80484a4 <__libc_csu_init+4>:   push   esi
   0x80484a5 <__libc_csu_init+5>:   push   ebx
```

Now, run the program again (`r` instruction) and use `c` to jump to the second breakpoint.
Use `si` instruction. In this case, the instruction pointer jumps to the first instruction in the `print_message` function.

```
(gdb) stepi
0x0804841b in print_message ()
1: x/10i $eip
=> 0x804841b <print_message>: push   ebp
   0x804841c <print_message+1>:  mov    ebp,esp
   0x804841e <print_message+3>:  sub    esp,0x8
   0x8048421 <print_message+6>:  sub    esp,0xc
   0x8048424 <print_message+9>:  push   0x8048520
   0x8048429 <print_message+14>: call   0x80482f0 <printf@plt>
   0x804842e <print_message+19>: add    esp,0x10
   0x8048431 <print_message+22>: nop
   0x8048432 <print_message+23>: leave  
   0x8048433 <print_message+24>: ret  
  ```
  

This is not it! These are just the instructions I frequently use during my debugging sessions. There may be some instructions you need but aren't there in this tutorial.
I leave the task of finding those instructions to you!

Links:

* A [cheat sheet](http://www.yolinux.com/TUTORIALS/GDB-Commands.html) I would recommemd 


> Written By : [Punit Dhoot](https://github.com/pdhoot/)


