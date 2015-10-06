import java.util.*;
import java.math.*;

public class solution {

	static int nextRandomNum() {
		return (int)(Math.random() * 6 + 1);
	}

	static int[] rollN(int n) {
		if (n <= 0) return null;

		int[] randomArray = new int[n];
		for(int i = 0; i < n; i++)
			randomArray[i] = nextRandomNum();

		return randomArray;

	}









	static int o2o(int[] dice) {
		int sum = dice[0] + dice[1]*7 + dice[2]*7*7;
		sum = (int)sum/3;	
		sum = sum - dice[3] - dice[4];
		if (sum > 100) 
			return (int)(sum - sum%100);
		else
			return sum;
	}


	static int[] build100Table(int[] sample) {
		for(int i=0; i<10000; i++) {
			int randIndex = o2o(rollN(6));
			sample[randIndex - 1]++;
		}
		return sample;
	}

	static void howRandom() {
		int[] sample = new int[100];
		int point = 0;
		sample = build100Table(sample);
		printArray(sample);
		for(int i=0; i<100; i++) {
			if(sample[i] >= 90 && sample[i] <= 110) point++;
			System.out.println("--->:" + point); 
		}	
		System.out.println(point/(double)100.0);
	}











	static void printArray(int[] sample) {

		for(int i=0; i<sample.length; i++)
			System.out.print(sample[i] + " ");

		System.out.println("");


	}

	static int rollNDice(int n) {
		int sum = 0;
		for (int i=0; i<n; i++)
			sum += nextRandomNum();
		return sum;
	}

	static int maxIndex(int n) {

		BigInteger x = BigInteger.valueOf(0);

		int[] table = new int[n * 6 + 1];
		for(int i=0; i<2000; i++) {
			int rand = nextRandomNum();
			table[rand] = table[rand] + 1;
		}
		int max = 0;
		for(int i=0; i<table.length; i++)
			max = (table[i] > max) ? table[i] : max;

		for(int i=0; i<table.length; i++)
			if(table[i] == max) return i;

		return -1;

	}	
	
	
	
	
	
	/**
 *
 *
	static int findWay(int numOfDice, int key) {

		int[][] table = new int[numOfDice + 1][key + 1];
		for(int i=1; i<=6 && i<=key; i++)
			table[1][i] = 1;

		for(int i=2; i<= numOfDice; i++)
			for(int j=1; j<=key; j++)
				for(int k=1; k <= 6 && k<j; k++)
					table[i][j] += table[i-1][j-k];

		return table[numOfDice][key];

	}
*/
	static BigInteger findWay(int numOfDice, int key) {

		BigInteger[][] table = new BigInteger[numOfDice + 1][key + 1];

		for(int i=0; i<numOfDice+1; i++)
			for(int j=0; j<key+1; j++)
				table[i][j] = new BigInteger("0");

		for(int i=1; i<=6 && i<=key; i++)
			table[1][i] = new BigInteger("1");

		for(int i = 2; i <= numOfDice; i++)
			for(int j = 1; j <= key; j++)
				for(int k = 1; k <= 6 && k < j; k++) {
					table[i][j] = table[i][j].add(table[i-1][j-k]);
				}
		return table[numOfDice][key];

	}
	static BigInteger[] buildCountTable(int numOfDice) {
		BigInteger[] countTable = new BigInteger[numOfDice * 6 + 1];
		
		// countTable[0][0] always empty, so I use this 
		// chance to store MaxCount
		BigInteger maxCount = new BigInteger("0");  // will be: countTable[0]
		
		for(int i = 1; i <= numOfDice * 6; i++) {
			countTable[i] = new BigInteger(findWay(numOfDice, i).toString());
			maxCount = maxCount.max(countTable[i]);
		}

		countTable[0] = new BigInteger(maxCount.toString());
		return countTable;
	}

	static int[] mfs(int n) {
		if (n == 0) return new int[0];
		
		// if n is odd; size of maxFreq:  2 (1 + 1) 
		// if n is even; size of maxFreq: 1 (0 + 1) 
		int[] output = new int[n % 2 + 1];
		BigInteger[] countTable = buildCountTable(n);
		BigInteger maxFreq = countTable[0];
		int indexOfOutput = 0;
		
		for (int i = 1; i < (n * 6); i++) {
			if (countTable[i].equals(maxFreq)) output[indexOfOutput++] = i;
			System.out.println("i: " + i + "\ttable[i]: " + countTable[i]);
		}

		System.out.println("maxFreq: " + maxFreq);
		return output;
	}






	public static void main(String[] args) {

		//printArray(rollN(20));
		//printArray(mfs(2));
		//printArray(buildCountTable(2));
		//System.out.println(mmm(2));

		//for(int i=0; i<30; i++)
		//	System.out.println(rollNDice(2));
		howRandom();
		

	}
}





