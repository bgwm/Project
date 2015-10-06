class MissingNumberInArray {

	public int missNum(int[] A) {
		
		if (A == null) return -1;
		if (A.length%2 == 0) return -1;

		int missNum = A[0];
		for(int i=1; i<A.length; i++) {
			missNum = missNum^A[i];
		}
		return missNum;

	}

	public void __test1__ (int[] A, int ans) {

		System.out.println("-------");
		for(int i=0; i<A.length; i++)
			System.out.print(A[i] + " ");
		System.out.println(" ");

		System.out.println(ans + ": " + missNum(A));
	}

	public void test1() {
		 __test1__(new int[]{0, 1, 1}, 0);
		 __test1__(new int[]{1, 1, 1}, 1);
		 __test1__(new int[]{1}, 1);
		 __test1__(new int[]{1, 1, 2, 2, 3, 3}, -1);
		 __test1__(new int[]{}, -1);
		 __test1__(new int[]{1,1,3,4,3}, 4);


	}
	public static void main(String[] args) {

		MissingNumberInArray twitter = new MissingNumberInArray();

		twitter.test1();
	}

}

























































































