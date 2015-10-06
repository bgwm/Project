public class Testing {


	public static void main(String[] args) {
	
		String PATH = "./out/ipsoft_perf_counters_csv_sample_data.txt";
		String pATH = "./out/ipsoft_perf_counters_csv_sample_data_test.txt";
		Data data = new Data(PATH);
		//data.print();
		//data.filter("site_id", "101").print();
		//data.printList(data.groupBy("site_location","DESC"));
		//data.sortBy("load_avg_5min").produceCSV(pATH);

		String[] params = {"load_avg_15min", "site_name"};
		data.sortBy(params).produceCSV(pATH);


		//data.sortBy("load_avg_5min").produceCSV(pATH);

		//data.produceCSV(pATH);
	}


}
