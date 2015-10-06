public class Match {


	public void test(String pattern, String str) {
		System.out.println("Test (" + pattern + ", " + str +"): " +
				compare(pattern, str));
	}


	public boolean compare(String pattern, String str) {
		
		// Both String end
		if(pattern.length() == 0 && str.length() == 0)
			return true;
		// If only one of the string end, that means they are NOT match
		else if (pattern.length() == 0 || str.length() == 0)
			return false;

		// If pattern contains only one char which is *
		if (pattern.charAt(0) == '*' && pattern.length() == 1)
			return true;
		// if Pattern starting with * string end
		else if(pattern.charAt(0) == '*' && str.length() == 0)
			return false;

		if(pattern.charAt(0) == '?' ||
				pattern.charAt(0) == str.charAt(0))
			return compare(pattern.substring(1), str.substring(1));

		if(pattern.charAt(0) == '*') 
			return compare(pattern.substring(1), str) ||
							compare(pattern, str.substring(1));
	
		
		return false;	

	}


	public static void main(String[] args) {
	
		Match match = new Match();
		match.test("abcd", "abcd");
		match.test("a*d", "abcd");
		match.test("a*", "abcd");
		match.test("a*a*a*a", "aaaaaaaaaa");
		match.test("*a", "aaaaaaaaaa");
		match.test("*ab", "aaaaaaaaaa");
		match.test("a*ab", "aaaaaaaaaa");
		match.test("ab*bab", "abcbab");
		match.test("ab*bab", "abcabcabcbab");
		match.test("ab?bab", "abcabcabcbab");
		match.test("ab?bab", "abcbab");

	}
}
