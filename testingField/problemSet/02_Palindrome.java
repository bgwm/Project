class Palindrome {

	public boolean isValidCase (String sampleStr) {
		if (sampleStr == null) return false;
		if (sampleStr.isEmpty()) return false;
		
		// Policy dependent, may or may not need following:
		// if (sampleStr.trim().isEmpty()) return false;
		return true; 
	}
	public boolean isPaliam(String sampleStr) {
	
		sampleStr = sampleStr.trim();
		if (!isValidCase(sampleStr)) return false;

		boolean isPaliam = true;
		int i_left = 0, i_right = sampleStr.length() - 1;
	
		while (i_left < i_right && isPaliam) {
			if (sampleStr.charAt(i_left++) != sampleStr.charAt(i_right--))
				isPaliam = false;
			// i_left++;
			// i_right--;
		}	

		return isPaliam;

	}

	public void __test1__ (String name, boolean ans) {
		System.out.println("--------\n\"" + name + "\"");
		System.out.println(ans + ": " + isPaliam(name));
	}

	public void test1() {

		__test1__("a", true);
		__test1__("", false);
		__test1__(" ", false);
		__test1__("                 ", false);
		__test1__("             i    ", true);
		__test1__("aa", true);
		__test1__("aaa", false);
		__test1__("abc", false);
		__test1__("redder", true);
		__test1__("racecar", true);
		__test1__("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", true);
		__test1__("a b a", false);
		__test1__("      a b a ", false);

	}
	public static void main(String[] args) {

		Palindrome twitter = new Palindrome();

		twitter.test1();
	}

}

























































































