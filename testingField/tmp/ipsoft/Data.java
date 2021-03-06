import java.util.*;

class Data {

	private List<Row> rows;
	private Row header;

	public Data (Row row) {
		rows = new ArrayList<Row>();
		rows.add(row);
		header = new Row(rows.get(0));	
	}

	public Data (List list) {
		rows = (List<Row>)list;
		header = new Row(rows.get(0));	
	}


	public Data (String dir) {
		String[] extension = dir.split("\\.(?=[^\\.]+$)");

		// 1. Parse Content
		if (extension[1].compareTo("txt") == 0) 
			rows = Parse.openCSV(dir);
		
		//else if (extension[1].compareTo("xml") == 0) 
		//	rows = Parse.openXML(dir);

		
		// 2. Parse Header
		header = new Row(rows.get(0));	
	}

	public Data sortBy(String param) {
		String[] params = {param};
		return sortBy(params);
	}

	public Data sortBy(String param, String order) {
		String[] params = {param};
		String[] orders = {order};

		return sortBy(params, orders);
	}

	public Data sortBy(String[] params) {
		String[] orders = new String[params.length];

		for (int i=0; i<params.length; i++)
			orders[i] = "ASC";

		return sortBy(params, orders);
	}

	public Data sortBy (String[] params, String[] orders) {
		return sortBy (params, orders, 0); 
	}	

	public Data sortBy(String[] params, String[] orders, int index) {
		if (index >= params.length) return new Data(rows);
		if (rows.size() == 1) return new Data(rows);

		String sortKey = params[index];
		String order = orders[index];

		System.out.println(" " + getList().size() + "(0)");

		List<Data> dataGroup = groupBy(params[index], orders[index]);
		for (Data data: dataGroup)
			System.out.print(" " + data.getList().size());
		System.out.println("(1)");

		for (int i=0; i<dataGroup.size(); i++) {
			dataGroup.set(i, dataGroup.get(i).sortBy(params, orders, ++index));
			System.out.print(" " + dataGroup.get(i).getList().size());
		}
		System.out.println("(2)");

		rows = merge(dataGroup);
		System.out.println(" " + rows.size() + "(3)");

		return new Data(rows);
	}	
		
	/** Group current 'rows' into sub-Data by the given parameter. 
	 *  row(Row) with same given parameter will goes into same Data.
	 *  Finally, keep the order of sub-Data by the given parameter.
	 *
	 *  Example:
	 *	 rows: [ [1,2,3], [1,5,2], [5,2,6], [5,1,4] ]
	 *
	 *  groupBy the first element:
	 *
	 *   dataGroup: [ 
	 *					[ [1,2,3], [1,5,2] ]
	 *					[ [5,2,6], [5,1,4] ]
	 *				]
	 */
	public List<Data> groupBy(String param, String order) {
		TreeMap<String, Data> dataGroup = new TreeMap<String, Data>();

		for (Row row : rows) {
			String key = row.getValue(param);

			if (dataGroup.get(key) == null)
				dataGroup.put(key, new Data(row));
			else
				dataGroup.get(key).add(row);
		}
		
		/** Convert 'dataGroup' into plain list (ArrayList) with
		 *  the given order: 'order'. TreeMap will keep the nature 
		 *  order, and NavigableMap which produced by descendingMap()
		 *  will produce the descending order.
		 *
		 *  only "ASC" and "DESC" are valid order input.
		 */ 
		if (order.compareTo("ASC") == 0)
			return new ArrayList<Data>(dataGroup.values());
		else if (order.compareTo("DESC") == 0) {
			NavigableMap descMap = dataGroup.descendingMap();
			return new ArrayList<Data>(descMap.values());
		}

		return null;
	}

	/** Merge group of data into one big data. inverse function of 
	 *  groupBy.
	 */
	public List<Row> merge(List<Data> dataGroup) {
		List<Row> newList = new ArrayList<Row>();
		for (Data data : dataGroup) {
			newList.addAll(data.getList());
		}	
		return newList;
	}


	public void add(Row row) {
		rows.add(row);
	}

	public List<Row> getList() {
		return this.rows;
	}

	public Data filter (String filterField, String value) {
		List<Row> newList = new ArrayList<Row>();

		Iterator it = rows.iterator();
		while (it.hasNext()) {
			Row newRow = (Row)it.next();
			if (newRow.getValue(filterField).compareTo(value) == 0)
				newList.add(newRow);
		}
		return new Data(newList);	
	}

	public void produceCSV(String dir) {
		Parse.produceCSV(header, rows, dir);
	}


	public void printList(List<Data> d) {
		for(Data data : d) {
			data.print();
			System.out.println("------------------");
		}
	}


public void print () {
		for (Row row : rows) {
			row.print();
			System.out.println(" ");
		}
	}
	//flat(flat(flat(groupBy( groupBy( groupBy(rows, 'name'), 'age'), 'height'))))




}


