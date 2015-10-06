class MaxStockProfit {

	public int max(int a, int b) {
		return (a >= b ) ? a : b;
	}

	public int solution(int[] A) {
		if (A == null) return 0;
		if (A.length == 1) return 0;

		int gobal = 0, local = 0;
		for (int i=1; i<A.length; i++) {
			//local = max(0, A[i] - A[i-1] + local
			int tmpGap = A[i] - A[i-1];
			local = max(tmpGap, tmpGap + local);
			gobal = max(local, gobal);
		}
		return (gobal = (gobal > 0) ? gobal : 0);
	}

	public static void main(String[] args) {
		MaxStockProfit x = new MaxStockProfit();
		
		int gobal = x.solution(new int[]{23171, 21011, 21123, 21366, 21013, 21367});
		System.out.println("answer: " + gobal);
	}


}
