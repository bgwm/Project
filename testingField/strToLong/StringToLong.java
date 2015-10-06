/** 
 * Name: 	Haolong Ning
 * Email:	Ning.Haolong@gmail.com
 */

import java.math.*;
import java.lang.*;
import java.util.regex.*;

public class StringToLong {

	/** Method will transfer a charactor to corrsponding value(integer)
	 *  based on it's representation, eg:
	 *  	'1'  --> 1	(base 10, 8, 16)
	 *  	'9'  --> 9	(base 10, 16)
	 *  	'7'  --> 7 	(base 8, 10)
	 *  	'A'  --> 10	(base 16)
	 *  	'F'  --> 15	(base 16)
	 *  	'G'  --> error	(base 10, 8, 16)
	 *  	'8'  --> error  (base 8)
	 *  return -1 -1 if error occur.
	 */
	private static int toInt (char ch) {

		if ('a' <= ch && ch <= 'f')
			return ch - 'a' + 10;

		else if ('A' <= ch && ch <= 'F')
		       return  ch - 'A' + 10;
		
		else if ('0' <= ch && ch <= '9')
			return ch - '0';
		
		else 
			return -1;	
	}

	/** Method will check if a given string -- which plan to transfer 
	 *  to 'long' type -- is overflow; in particular, those ranges
	 *  are:
	 *  
	 *  	Hex: (-0x8000000000000000, 0x7FFFFFFFFFFFFFFF)
	 *  	Dec: (-922337203685477808, 922337203685477807)
	 *  	Oct: (-1000000000000000000000, 77777777777777777777) 
	 *
	 */
	private static boolean additionIsOverflow (long a, int b) {
		boolean additionIsOverflow = false;

		//System.out.println("(a,b):\t" + a + " " + b);

		if (a > 0 && b > Long.MAX_VALUE - a)
			additionIsOverflow = true;
		else if (a < 0 &&  b < Long.MIN_VALUE - a)
			additionIsOverflow = true;
	
		return additionIsOverflow;
	}
	private static boolean multiplyIsOverflow (long a, int factor) {
		boolean multiplyIsOverflow = false;

		//System.out.println("(a,factor):\t" + a + " " + factor);

		if (a > 0 && a > Long.MAX_VALUE/factor)
			multiplyIsOverflow = true;
		else if (a < 0 &&  a < Long.MIN_VALUE/factor)
			multiplyIsOverflow = true;
	
		return  multiplyIsOverflow;
	}

	/** Method should be called from here, my program handle three types 
	 *  way to declare a long type:
	 *  	
	 *  	long l = 0xff;	// Hex number 
	 *  	long l = 037;	// Oct number
	 *  	long l = 123;	// Dec number
	 *
	 *  More testing case demonstrated on test() method.
	 */
	public static long stringToLong(String str) {
					
		long num = 0;
		int factor, dight, sign = 1; // Default positive number

		// -1024 to 1024, -037L to 037L, -0xffL to 0xffL
		if (str.charAt(0) == '-') {
			sign = -1;
			str = str.substring(1);
		} 
		else if (str.charAt(0) == '+') {
			str = str.substring(1);
		}

		// 1024L to 1024, 037L to 037, 0xffL to 0xff	
		char tail = str.toLowerCase().charAt(str.length() - 1);
		if (tail == 'l')
			str = str.substring(0, str.length() - 1);
	
		
		String hexPrefix = "", octPrefix = "";
		if (str.length() > 2) {
			hexPrefix = str.substring(0, 2).toLowerCase();
			octPrefix = str.substring(0, 1).toLowerCase();
		} else if (str.length() > 1) {
			octPrefix = str.substring(0, 1).toLowerCase();
		} 
		
		/** Decide if the number represented as based on 16, 
		 *  based on 8, or based on 10. */
		if (hexPrefix.compareTo("0x") == 0) {
			str = str.substring(2);
			factor = 16;
		} 
		else if (octPrefix.compareTo("0") == 0) {
			str = str.substring(1);
			factor = 8;
		}
		else 
			factor = 10;
		
		// Converting String to Long char by char	
		for (int index = 0; index < str.length(); index++) {
			dight = toInt(str.charAt(index));
			
			if (dight == -1) {
				System.out.print("Invalid char:  ");
				return -1;
			}
			
			if (factor == 8 && dight > 7) {
				System.out.print("Invalid char for Octal:  ");
				return -1;
			}
			
			if (multiplyIsOverflow(num * sign, factor)) {
				System.out.print("Number overflow:  ");
				return -1;
			}
			
			num *= factor;
			
			if (additionIsOverflow(num * sign, dight)) {
				System.out.print("number overflow:  ");
				return -1;
			}

			if (num >= 0)
				num += dight;
			else 
				num -= dight;
		}
		return  num * sign;
	}

	/** Method handled in following way, the types of sign of a number 
	 *  could be ''(default as positive), '+', and '-'; the types of 
	 *  long type can be declared by add 'l', 'L' or '' (which is 
	 *  nothing) to the tail of the number:
	 *  	
	 *  	123, 123l, and 123L
	 *
	 *  In total, there are 3 * 3 = 9 possible combinations, take 
	 *  '0xff' as example:
	 *
	 *  	 0xff,  +0xff,  -0xff,   0xffl, 0xffL,
	 *  	+0xffl, +0xffL, -0xffl, -0xffL
	 *
	 *  totally 9 possible conbinations;
	 *  To use this method, caller only need to pass most regular number,
	 *  which likes: 0xff, 312, or 0123; No need to declare '+'/'-' and 
	 *  'l'/'L'; method will automatically test those cases for you.
	 */  
	public static void __test__(String str) {
		long num;
		String s;
		
		System.out.println("Testing case:\t" + str);

		s = str;
		num = stringToLong(str);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = "+" + str;
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = "-" + str;
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = str + "l";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = str + "L";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = "+" + str + "l";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);

		s = "+" + str + "L";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);
		
		s = "-" + str + "l";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n", s, num);
		
		s = "-" + str + "L";
		num = stringToLong(s);
		System.out.printf("%s\tconverted to:\t%d\n\n", s, num);
	}	

	public static void test () {

		System.out.println("Long.MIN_VALUE:");
		BigInteger t = new BigInteger(Long.MAX_VALUE + "", 10);
		System.out.println("Dec:\t" + t.toString(10));
		System.out.println("Hex:\t" + t.toString(16));
			
		System.out.println("\nLong.MIN_VALUE:");
		t = new BigInteger(Long.MIN_VALUE + "", 10);
		System.out.println("Dec:\t" + t.toString(10));
		System.out.println("Hex:\t" + t.toString(16));

		System.out.println("\n-----Demonstrate Testing Case-----\n");
		
		// regular case
		__test__("0");
		__test__("1");
		__test__("0xffadc12");
		__test__("07777777777");
		__test__("9223372036854775807");
		__test__("0x8000000000000000");
		__test__("1.1");
		__test__("0xQWEYQWUIYE");
		__test__("03451238");
	}

	public static void main(String[] args) {
		test();	

		// One always can call stringToLong(String str) directly:
		// long test = stringToLong("123");

	}
}
