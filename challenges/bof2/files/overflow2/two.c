/* Compiled as:
 * gcc -m32 -fno-stack-protector -0 two two.c
 */

#include <stdio.h>
#include <stdlib.h>

#define N 100
void win()
{
	printf("How the heck did you reach here!\nYou definitely must be a hacker!\nCongratulations!\n");
}

void lose()
{
	printf("Not even close!\nTry again! :p\n");
}

int main(int argc, char* argv[])
{
	printf("Enter your name:\n");
	void (*func)();
	func = lose;
	char name[N];
	gets(name);
	func();
}