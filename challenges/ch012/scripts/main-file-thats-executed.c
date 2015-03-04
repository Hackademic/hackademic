#include<stdio.h>
#include<string.h>
#include<stdlib.h>
//The query entered by user is given as an input to this program so that it is handled appropriately.
//the debugging information about executable,runtime environment is present in the file 'Debugging: Output of GDB.txt'

//take query from user
int ask_query()
{
	char query[10];
	gets(query);
	
	printf("Your query has been recorded. We'll reply back to you\n");
}

//list all quiries
void list_quiries()
{
	printf("Here are all the quiries:\n");
}

//note: this never gets executed, should never be executed
void delete_all()                                             
{
	printf("All Accounts, Account details deleted successfully\n");
}

//send reply to user
void reply_to_user()
{
	printf("Your query is solved. We have a great solution for your problem.Contact us and we'll let you know\n");
}

int main()
{
	ask_query();	
	return 0;
}
