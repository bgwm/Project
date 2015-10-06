import java.util.*;

public class Row {

	private HashMap<String, String> row;

	// For default
	public Row () {
		row = new LinkedHashMap<String, String>();
	}

	// For Header
	public Row(Row rowInput) {
		row = new LinkedHashMap<String, String>();

		Iterator it = rowInput.getRow().entrySet().iterator();
		while (it.hasNext()) {
			Map.Entry pairs = (Map.Entry)it.next();
			String hdr = (String)pairs.getKey();
			row.put(hdr, hdr);
		}	
	}

	// For Content
	public Row(String[] header, String[] content) {

		int length;
		if (header.length != content.length)
			return;
		else 
			length = header.length;

		row = new LinkedHashMap<String, String>();
		for (int i=0; i<length; i++) 
			row.put (header[i].trim(), content[i].trim());
	}

	public void setField (String fieldName, String value) {
		row.put (fieldName, value);
	}

	public HashMap getRow() {
		return row;
	}

	public String getValue(String Key) {
		return row.get(Key);
	}

	public String toString() {
		String flatedRow = "";
		Iterator it = row.entrySet().iterator();
		while (it.hasNext()) {
			Map.Entry pairs = (Map.Entry)it.next();
			flatedRow += pairs.getValue() + ",";
	
		}	
			StringBuilder tmpRow = new StringBuilder(flatedRow);
			tmpRow.setCharAt(flatedRow.length()-1, '\n');
			return tmpRow.toString();	
	}
	


	public void print () {
		Iterator it = row.entrySet().iterator();
		while (it.hasNext()) {
			Map.Entry pairs = (Map.Entry)it.next();
			System.out.println(" [\"" + 
								pairs.getKey() + "\":" + pairs.getValue() + 
							  "]");
		}
	}


}
