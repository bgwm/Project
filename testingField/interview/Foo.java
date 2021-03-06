class Foo {

	public boolean hasMoreValue(int[] sample, int count) {
		return (sample.length >= count) ? true : false;
	}


	public void readNextBlock(int[] sample, int n) {
		System.out.println("check: " + n);
		for(int i=0; i<80 && (n+i < sample.length); i++) {
			System.out.print(" " + sample[n+i]);
		}
	}


	public void readFullFile(int[] sample){	
		int count = 0;	
		while( hasMoreValue(sample, count) ) {
			readNextBlock(sample, count);
			count += 80;
			System.out.println("\n---- BREAK ----");
		}
	

	}
	public void printArray(int[] arr) {
		for(int i : arr)
			System.out.print(" " + i);
		System.out.println("");
	}

	public int[] generateNum(int n) {
		int[] arr = new int[n];
		for(int i=1; i<=n; i++)
				arr[i-1] = i;
		return arr;
	}

	public static void main(String[] args) {
		Foo foo = new Foo();
		int[] sample = foo.generateNum(1000);
		foo.printArray(sample);

		foo.readFullFile(sample);

	}

}
