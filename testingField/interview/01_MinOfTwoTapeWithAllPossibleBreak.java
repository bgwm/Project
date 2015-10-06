class MinOfTwoTapeWithAllPossibleBreak {
   
    public int solution(int[] A) {
    
        int sum = 0, posSum = 0;
        for (int i = 0; i < A.length; i++) {
            sum += A[i];
			posSum += Math.abs(A[i]);
		}
            
		/** Use minGap = Math.abs(sum) is WRONG.
		 * [-10, 0, 10], sum = 0 = minGap. 
		 * while the answer for this data set is 10
		 * Need use: 
		 *		posSum += Math.abs(A[i]);
		 */	
        int subSum = 0, minGap = posSum;
        for (int i = 0; i < A.length - 1; i++) {

			/** subSum is required, have to increament by 
			 * each element */
            subSum += A[i];
            int gap = Math.abs(2 * subSum - sum);
            minGap = (minGap > gap) ? gap : minGap; 
        }
        return minGap;
        
    }

	

}
