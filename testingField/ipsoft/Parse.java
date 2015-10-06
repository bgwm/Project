import java.util.*;
import java.io.*;
import javax.xml.*;
import javax.xml.XMLConstants;
import javax.xml.bind.*;
import javax.xml.validation.*;
import javax.*;


class Parse {

	public static List openCSV (String dir) {
		return openCSV(dir, ",");
	}

	public static List openCSV (String dir, String delimter) {
		
		BufferedReader br = null;
		List<Row> rows = new ArrayList<Row>(); 


		try {
			br = new BufferedReader(new FileReader(dir));
		
			Row row = null;
			String[] headers = null;
			String buffer = "";
			
			// 1. Read header
			buffer = br.readLine(); 
			if (buffer != null) {
				headers = buffer.split(delimter);
			}	
			
			// 2. Read content
			while ((buffer = br.readLine()) != null) {
				row = new Row (headers, buffer.split(delimter));	
				if (row != null) 
					rows.add(row);
			}

		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			// always remember close file if opened.
			if (br != null) {
				try { br.close(); }
				catch (IOException e) { e.printStackTrace(); }
			}
		}	
		
		return ((rows.size() != 0) ? rows : null);
	}

	/**
	public static List openXML (String dir) {

	}
	*/


	public static void produceCSV (Row header, List map, String dir) {
		System.out.println(dir);	

		
		try {
			File file = new File(dir);
			if (!file.exists()) file.createNewFile();
			
			BufferedWriter bw = new BufferedWriter(new FileWriter (
									file.getAbsoluteFile()));

			// 1. Write Header
			bw.write(header.toString());			

		    // 2. Write Content	
			for (Object row : map) {
				bw.write(((Row)row).toString());
			}

			bw.close();	

		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public static void produceXML (Data data, String dir) throws Exception {
		File file = new File("./output.xml");
		JAXBContext jc = JAXBContext.newInstance(Data.class);
		Marshaller mlr = jc.createMarshaller();

		mlr.setProperty(Marshaller.JAXB_FORMATTED_OUTPUT, true);
		mlr.marshal(data, file);
		mlr.marshal(data, System.out);
	}	



}











































































	
