class Twitter {

	public int solution (int[] A) {
		int sum = 0; odd = 0; even = 0;
		for (int i=0; i<A.length; i++) 
			if (A[i] % 2 == 0) sum += even++;
			else sum += odd++;
		return sum;
	}


	public void __test1__ (int[] A, int ans) {

		System.out.println("-------");
		System.out.println(ans + ": " + solution(A));
	}

	public void test1() {
		 __test1__(new int[]{1, 2, 3, 4, 5, 6}, 6);
		 __test1__(new int[]{1, 4, 5, 0, 2, 6}, 6);


	}
	public static void main(String[] args) {

		Twitter twitter = new Twitter();

		twitter.test1();
	}

}

























































































