#include <cstdlib>
#include <cstdio>
#include <iostream>
using namespace std;
long long akkerman(int m, int n) {
								if (m == 0)
								{
																return n +1;
								}
								if (m > 0 and n == 0)
								{
																return akkerman(m - 1, 1);
								}
								return akkerman(m - 1, akkerman(m, n - 1));
}


int main (int argc, char** argv){
								cout << akkerman(atoi(argv[1]),atoi(argv[2]));
								return 1;
}
