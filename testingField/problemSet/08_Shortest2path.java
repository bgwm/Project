class Twitter {

	public int solution (int A) {
		if (A == 1) return 1;
		int count = 0, B = A;
		while (B > 0) {
			B /= 2;
			count++;
		}
		return (A % 2 == 0) ? count : (count + 1);
	
	
	}


	public void __test1__ (int A, int ans) {

		System.out.println("-------");
		System.out.println(ans + ": " + solution(A));
	}

	public void test1() {

			__test1__(17, -1);
			__test1__(1, -1);
			__test1__(3, -1);
			__test1__(1024, -1);

	}
	public static void main(String[] args) {

		Twitter twitter = new Twitter();

		twitter.test1();
	}

}

























































































