package com.example.myfirstapp.AbsType;

import java.io.File;
import java.util.ArrayList;
import java.util.Random;

import android.util.Log;

import com.example.myfirstapp.*;
public class AbsType {

	private String type = "";
	
	public static int R(int size) {
		Random r = new Random();
		return (int)r.nextInt(size);
	}
	
	
	public static Object getType(String typeName){
		Object obj = null;
		Log.e("Whaterver", typeName);
		if(typeName.compareTo("String") == 0) {
			ArrayList<String> strList = new ArrayList<String>();
			String str = "";
			
			// one 
			str = "1----/";
			strList.add(str);
			
			str = "$PATH$:/";
			strList.add(str);
			
			str = "\64\2\67\34/";
			strList.add(str);
			
			str = "--.-%DIR%-/";
			strList.add(str);
			
			str = "----/";
			strList.add(str);
			
			str = "./.";
			strList.add(str);
			
			str = "-/";
			strList.add(str);
			
			str = "\01\01\01\01\01\01\01\01\01\01\01\01";
			strList.add(str);
			
			str = "\00\00\00\00";
			strList.add(str);
			
			str = "\177\177\177\177\177\177\177\177\177";
			strList.add(str);
			
			str = "######";
			strList.add(str);
			
			str = "\140echo 1";
			strList.add(str);
			
			str = "\140;echo 1";
			strList.add(str);
			
			str = "ls *sjgl";
			strList.add(str);
			
			str = "&df ";
			strList.add(str);
			
			str = "./--- /";
			strList.add(str);
			
			str = "--";
			strList.add(str);
			
			str = "%n%s%d";
			strList.add(str);
			
			str = "--10101/";
			strList.add(str);
			
			str = "ls -";
			strList.add(str);
			
			str = "er && ";
			strList.add(str);
			
			str = "--../--.";
			strList.add(str);
			
			str = "||";
			strList.add(str);
			
			str = "&&for !";
			strList.add(str);
			
			str = "0XFFFFFFFF";
			strList.add(str);
			
			str = "0X00000000";
			strList.add(str);
			
			str = "0X-- 0X";
			strList.add(str);
			
			str = "0XFF0101110";
			strList.add(str);
			
			str = "0X&er111";
			strList.add(str);
			
			for(int j=0; j<30; j++) {
				for(int i=0; i<128; i++)
					str += (char)(47+R(75)) + "";
				strList.add(str);
			}
			
			
			String ret = strList.get(R(strList.size()));
			Log.w("String", ret);
			return ret;
		}

		if(typeName.compareTo("char") == 0 ) {
			char ch = 'x';
			ch = (char)(46 + R(75));
			
			return ch;
		}
		
		
		
		if(typeName.compareTo("float") == 0 ) {
			double[] d = {Float.MAX_VALUE, Float.MIN_VALUE, 0, -Float.MAX_VALUE, -Float.MIN_VALUE};
			double ret = d[R(5)];
			Log.w("double", ret + "");
			return ret;
		}
		

		
		if(typeName.compareTo("double") == 0 ) {
			double[] d = {Double.MAX_VALUE, Double.MIN_VALUE, 0, -Double.MAX_VALUE, -Double.MIN_VALUE};
			double ret = d[R(5)];
			Log.w("double", ret + "");
			return ret;
		}
			
		if(typeName.compareTo("int") == 0) {
			int[] i = {Integer.MAX_VALUE, Integer.MIN_VALUE, 0, -Integer.MAX_VALUE, -Integer.MIN_VALUE};
			int ret = i[R(5)];
			Log.w("int", ret + "");
			return ret;
		}
		
		if(typeName.compareTo("long") == 0 
			|| typeName.compareTo("short") == 0
			|| typeName.compareTo("byte") == 0 ) {
			long[] d = {Long.MAX_VALUE, Long.MIN_VALUE, 0, -Long.MAX_VALUE, -Long.MIN_VALUE};
			long ret = (long)d[R(5)];
			Log.w("long", ret + "");
			return ret;
		}
		
		if(typeName.contains("File")) {
		//if(typeName.compareTo("java.io.File") == 0) {
			File file = FileGenerator.getRandomFile();
			Log.w("FileName", file.getName() + "");
			return file;
		}
		Log.w("Object", "New Object");
		return obj; 
	}
	
	
	
}
