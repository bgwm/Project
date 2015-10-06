class Twitter {

	public int __solution__(int[] A, int nextIndex, int count) {
		if (count > A.length) return -1;
		if (nextIndex >= A.length) return count;
		/** there is actually no way we can do this without 
		 *  iterating the entire loop as to pre-process the 
		 *  record map would require O(n^2) time */
		return __solution__(A, A[nextIndex], ++count);

	}

	public int solution(int[] A) {
		if (A == null) return -1;
		
		int max = 0;
		for (int i = 0; i < A.length; i++)
			max = Math.max(__solution__(A, i, 0), max);
		return max;
	}
	

	public void __test1__ (int[] A, int ans) {

		System.out.println("-------");
		System.out.println(ans + ": " + solution(A));
	}

	public void test1() {
		 __test1__(new int[]{1, 2, 3, 4, 5, 6}, 6);
		 __test1__(new int[]{5, 4, 0, 3, 1, 6, 2}, 6);


	}
	public static void main(String[] args) {

		Twitter twitter = new Twitter();

		twitter.test1();
	}

}

























































































