#include <stdio.h>
#include <stdlib.h>
#include <string.h>
 
#define N 1000
 
void shell()
{
	system("/bin/sh");
}
 
class B
{
	private:
		char buffer[32];
	public:
 
		void set(char* s1)
		{
			strcpy(buffer, s1);
		}
 
		virtual void fail()
		{
			printf("%s\n", "Something");
		}
};
 
class A:public B
{
	public:
		void fail()
		{
			printf("Hehe! You can't get the shell!\n");
		}
};
 
int main(int argc, char* argv[])
{
	A *Object[2];
	Object[0] = new A();
	Object[1] = new A();
	Object[0]->set(argv[1]);
	Object[1]->fail();
}
