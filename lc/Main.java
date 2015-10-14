class Main {

	public static void main(String[] args) {

		countPrimes t = new countPrimes();

		int ans = t.countPrimes(2);
		System.out.println("ans 2: " + ans);

		ans = t.countPrimes(4);
		System.out.println("ans 4: " + ans);

		ans = t.countPrimes(6);
		System.out.println("ans 6: " + ans);

		ans = t.countPrimes(21);
		System.out.println("ans 21: " + ans);
	}

}
