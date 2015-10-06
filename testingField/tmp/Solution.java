public class Solution {
    
    private int min(int a, int b, int c) {
        if (a <= b && a <= c) return a;
        if (b <= c && b <= a) return b;
        if (c <= a && c <= b) return c;
        
        return -1;
    }
    
    
    public int nthUglyNumber(int n) {
        if (n <= 0) return 0;
        if (n == 1) return 1;
        
        int p2 = 0;
        int p3 = 0;
        int p5 = 0;
        
        int[] pSet = new int[n];
        pSet[0] = 1;
        
        int count = 1;
        while (count < n) {
            pSet[count] = min(pSet[p2]*2, pSet[p3]*3, pSet[p5]*5);
            
            if (pSet[count] == pSet[p2]*2) p2++;
            if (pSet[count] == pSet[p3]*3) p3++;
            if (pSet[count] == pSet[p5]*5) p5++;
            
            count++;
        }
        return pSet[count-1];
    }
}
