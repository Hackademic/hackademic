#include <stdio.h>

void _admin_area() {

  system("/bin/sh");

}

void _add(int pos, int val, int* vektor) {

  vektor[pos] = val;

}

void _remove(int val, int* vektor) {

  int i;
  for (i = 0; i < 30; i++){
    if (vektor[i] == val){
      vektor[i] = 0;
      break;
    }
  }

}

void _show(int* vektor) {

  int i;
  printf("[ ");
  for (i = 0; i < 29; i++)
    printf("%d, ", vektor[i]);
  printf("%d ]", vektor[29]);

}

void print_motd(){

  puts("\n\n");
  puts(" \\ \\    / /  ____| |/ /__   __/ __ \\|  __ \\\n\
  \\ \\  / /| |__  | \' /   | | | |  | | |__) |\n\
   \\ \\/ / |  __| |  <    | | | |  | |  _  / \n\
    \\  /  | |____| . \\   | | | |__| | | \\ \\ \n\
     \\/   |______|_|\\_\\  |_|  \\____/|_|  \\_\\");
  puts("\n\n");
  puts("Welcome to the VEKTOR premium service!!\n");

}

void print_menu(){

  puts("1. Add to VEKTOR");
  puts("2. Remove from VEKTOR");
  puts("3. View VEKTOR position");
  puts("4. Show VEKTOR");
  puts("5. Exit");

}

int main(){

  int vektor[30] = {0};
  unsigned int pos, finito = 0;
  int n, choice;

  setbuf(stdin, 0);
  setbuf(stdout, 0);

  print_motd();

  while (1) {

    printf("\nWhat would you like to do?\n\n");
    print_menu();
    scanf("%d", &choice);

    switch(choice){
    case 1:
      printf("Enter position: ");
      scanf("%u", &pos);
      printf("Enter value: ");
      scanf("%d", &n);
      _add(pos, n, vektor);
      fgetc(stdin);
      break;
    case 2:
      printf("Enter value: ");
      scanf("%d", &n);
      _remove(n, vektor);
      fgetc(stdin);
      break;
    case 3:
      printf("Enter position: ");
      scanf("%u", &pos);
      printf("Value at position %u is %d\n", pos, vektor[pos]);
      fgetc(stdin);
      break;
    case 4:
      _show(vektor);
      break;
    case 5:
      finito = 1;
      break;
    default:
      puts("Invalid choice...");
      break;
    }

    if (finito) break;
  }

}
