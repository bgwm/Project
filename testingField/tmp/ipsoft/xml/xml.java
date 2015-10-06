import java.io.*;
import java.util.*;
import javax.xml.XMLConstants;
import javax.xml.bind.*;
import javax.xml.validation.*;
import javax.*;


public class xml {



	public static void main(String[] args) throws Exception{

		Sites sites = new Sites();
		// Data demo = new Data();
		
		File file = new File("./output.xml");
		JAXBContext jc = JAXBContext.newInstance(Sites.class);
		Marshaller mlr = jc.createMarshaller();

		mlr.setProperty(Marshaller.JAXB_FORMATTED_OUTPUT, true);
		mlr.marshal(sites, file);
		mlr.marshal(sites, System.out);
	}

}
