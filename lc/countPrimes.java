/* 204 */
class countPrimes {
	
	public int countPrimes(int n) {
		
		if (n <= 2) return n;
		

		int[] s = new int[n+1];
		int sum = 1;

		for (int i=2; i<=n; i++) {
			if (s[i] != 0) 
				continue;

			int j=1, m=0;	
			while ((m=i*j) <= n) {
				s[m] = 1;
				j++;
			}
			sum++;
		}

		return sum;

	}


}
