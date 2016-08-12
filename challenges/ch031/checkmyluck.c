/***
* This is the code that decides whether a user is lucky or not.
*  
* Instructions to technicians:
*  i) Update lucky_number everyday, 
* ii) Compile the program on our 64 bit machine as follows: gcc checkmyluck.c -mpreferred-stack-boundary=4 -fno-stack-protector -g
*
***/

#include<stdio.h>
#include<stdlib.h>
#include<string.h>

//coupon code for today, i.e. 01-01-2005
#define lucky_number "9876543210"           

int main(void)
{
	char coupon_number[12];
	int  jackpot_won = 0;

	printf("Enter the 10 digit Coupon Number:\n");
	gets(coupon_number);

	if (strcmp(coupon_number,lucky_number)==0)
	{
		jackpot_won = 1;
	}

	if(jackpot_won)
	{
		printf("Congrats, You have won a jackpot.\n");
	}
	else
	{
		printf("You are not the lucky winner. Better luck next time\n");
	}

	return 0;
}
