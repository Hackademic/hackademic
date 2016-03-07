/* Compiled as:
 * gcc -m32 -fno-stack-protector -0 one one.c
 */

#include <stdio.h>
#include <stdlib.h>

int main(int argc, char* argv[])
{
	if(argc<2)
	{
		printf("Not enough arguments.\n");
		exit(1);
	}

	int auth = 0;
	char buffer[100];
	strcpy(buffer, argv[1]);

	if(auth==0)
	{
		printf("You need to authenticate yourselves. Try again!\n");
		exit(0);
	}
	else
	{
		printf("Congratulations! You are authenticated.\n");
	}
}