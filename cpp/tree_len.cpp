#include <iostream>
#include <cstdlib>
#include <cstdio>
using namespace std;

int tree_len(int len,int deep){
        long long acc=len;
        int f;
        for (f=2; f<deep+1; f++) {
                acc=(acc+f)*len;
        }
        return acc;
}


int main(int argc, char* argv[]) {
        if ( argc < 3 ) {
                cout << "Bad arguments" << endl;
                return 666;
        }
        if (argv[1] != "1") {
                int len=atoi(argv[2]);
                int deep=atoi(argv[3]);
                cout << tree_len(len,deep) << endl;
        }
        return 1;
}
