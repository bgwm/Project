package com.example.myfirstapp;
import android.annotation.SuppressLint;
import android.app.*;
import java.io.*;
import java.nio.ByteBuffer;
import java.nio.channels.FileChannel;
import java.util.ArrayList;
import java.util.Random;

import android.content.Context;
import android.os.Environment;
import android.provider.MediaStore.Files;
import android.util.Log;


@SuppressLint("NewApi")
public class FileGenerator{

	private static ArrayList<File> files = null;
	private Context cnx = null;
	private String tag = "File Generator";
	
	boolean mExternalStorageAvailable = false;
	boolean mExternalStorageWriteable = false;
	
	public FileGenerator(Context cnx) {
		this.files = new ArrayList<File>();
		this.cnx = cnx;
		fileExplosion();
		
		LogCat.print("Class: FileGenerator", "Create New FileGenerator");
	}
	
	private void fileExplosion() {
		
		LogCat.print("FileGenerator.fileExplosion()", "enter");
		
			this.gen_LongNameFile();
			this.gen_MutipleLevelFile();
			this.gen_ReadonlyFile();
			this.gen_WriteonlyFile();
			this.gen_ExcuteonlyFile();
			this.gen_noRWXFile();
			this.gen_BigFile();
			this.gen_EmptyFile();
			this.gen_RootFile();
			this.gen_LongNameDir();
			this.gen_MutipleLevelDir();
			this.gen_ReadonlyDir();
			this.gen_WriteonlyDir();
			this.gen_ExcuteonlyDir();
			this.gen_noRWXDir();
			this.gen_RootDir();
			this.gen_WeirdNameDir();
			this.gen_WeirdNameFile();

			
			LogCat.print(tag, "files.size()=" + files.size());
		LogCat.print("FileGenerator.fileExplosion()", "exit");
	}
	
	public static File getRandomFile(){
		LogCat.print("FileGenerator.getRandomFile()", "enter");
		
		Random r = new Random();
		int range = (int)r.nextInt(files.size());
		
		LogCat.print("FileGenerator.getRandomFile()", "exit");
		return files.get(range);
	}
	
	private void gen_LongNameFile(){
		LogCat.print("FileGenerator.gen_LongNameFile()", "enter");
		
		File file = null;
		//Log.i(tag, "long name file");
		
		String fileName = "";
		for(int i=0; i<255; i++) 
			fileName += 'l'; 
		
		
		FileOutputStream fo;
		try{
			fo = cnx.openFileOutput(fileName, Context.MODE_PRIVATE);
			fo.write(" ".getBytes());
			
			LogCat.print("FileGenerator.gen_LongNameFile()", "create new File" + fileName);
			
			fo.close();
			
		}catch (Exception e)
		{
			e.printStackTrace();
		}
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_LongNameFile()", "exit");
	}
	
	private void gen_LongNameDir(){
		LogCat.print("FileGenerator.gen_LongNameDir()", "enter");
		
		File file = null;
		Log.i(tag, "long name dir");
		
		String fileName = "";
		for(int i=0; i<255; i++) 
			fileName += 'L'; 
		
	
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		
		if(file.exists())
		{
			file.delete();
		}
		
		file.mkdir();
		
		if(file.exists())
		{
			files.add(file);
			LogCat.print("FileGenerator.gen_LongNameDir()", "create new Dir" + file.getName());
		}
		LogCat.print("FileGenerator.gen_LongNameDir()", "exit");
	}
	
	
	private void gen_MutipleLevelFile() {
		LogCat.print("FileGenerator.gen_MutipleLevelFile()", "enter");
		
		File file = null;
		Log.i(tag," multiple level file");
		String oneLevel = "";
		String fileName = cnx.getFilesDir().getAbsolutePath() + "/";
		
		for(int i=0; i<255; i++)
			oneLevel += 'M';
		
		for(int i=0; i<15; i++)
			fileName += oneLevel + "/";
		
		File dir = new File(fileName);
		boolean mkdirRet = dir.mkdirs();
		
		fileName += "multipleLevel.txt";
		OutputStream myOutput;
		try {
			myOutput = new BufferedOutputStream(new FileOutputStream(fileName,true));
			myOutput.write("Multiple".getBytes());
			
			//LogCat.print("FileGenerator.gen_MutipleLevelFile()", "create new Dir:" + fileName);
			
			myOutput.flush();
			myOutput.close();
			
		} catch (Exception e)
		{
			e.printStackTrace();
		}
		
		file = new File(fileName);
		
		if(file.exists()) files.add(file);
		
		
		LogCat.print("FileGenerator.gen_MutipleLevelFile()", "exit");
	}
	
	private void gen_MutipleLevelDir() {
		LogCat.print("FileGenerator.gen_MutipleLevelFile()", "enter");
		
		File file = null;
		//Log.i(tag," multiple level dir");
		String oneLevel = "";
		String fileName = cnx.getFilesDir().getAbsolutePath() + "/";
		
		for(int i=0; i<255; i++)
			oneLevel += 'M';
		
		for(int i=0; i<15; i++)
			fileName += oneLevel + "/";
		
		//LogCat.print("FileGenerator.gen_MutipleLevelFile()", "FileName" + fileName);
		
		File dir = new File(fileName);
		boolean mkdirRet = dir.mkdirs();
		
		LogCat.print("FileGenerator.gen_MutipleLevelFile()", "dir.mkdirs return: " + mkdirRet);
		
		file = new File(fileName);
		if(file.exists()){
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_MutipleLevelFile()", "exit");
	}
	
	
	
	

	
	@SuppressLint("NewApi")
	private void gen_ReadonlyFile(){
		LogCat.print("FileGenerator.gen_ReadOnlyFile()", "enter");
		
		File file = null;
		String fileName = "readonly.txt";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		FileOutputStream fo;
		try{
		fo = cnx.openFileOutput(fileName, Context.MODE_PRIVATE);
		fo.write(" ".getBytes());
			LogCat.print("FileGenerator.gen_ReadOnlyFile()", "create new File" + fileName);
		fo.close();
		}catch (Exception e)
		{
			e.printStackTrace();
		}
		
		
		file.setExecutable(false);
		file.setWritable(false);
		file.setReadable(true);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_ReadOnlyFile()", "exit");
	}
	
	private void gen_ReadonlyDir(){
		LogCat.print("FileGenerator.gen_ReadOnlyDir()", "enter");

		File file = null;
		String fileName = "READONLY";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		file.mkdir();
		LogCat.print("FileGenerator.gen_ReadOnlyFile()", "create new Dir" + fileName);
		
		file.setExecutable(false);
		file.setWritable(false);
		file.setReadable(true);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_ReadOnlyDir()", "exit");
	}
	
	private void gen_WriteonlyFile(){
		LogCat.print("FileGenerator.gen_WriteOnlyFile()", "enter");
		
		File file = null;
		String fileName = "writeonly.txt";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		FileOutputStream fo;
		try{
			fo = cnx.openFileOutput(fileName, Context.MODE_PRIVATE);
			fo.write(" ".getBytes());
			LogCat.print("FileGenerator.gen_WriteOnlyFile()", "creat new File" + fileName);
			fo.close();
		}catch (Exception e)
		{
			e.printStackTrace();
		}
		
		
		file.setExecutable(false);
		file.setWritable(true);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_WriteOnlyFile()", "exit");
	}
	
	private void gen_WriteonlyDir(){
		LogCat.print("FileGenerator.gen_WriteOnlyDir()", "enter");
		
		File file = null;
		String fileName = "WRITEONLY";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		file.mkdir();
		LogCat.print("FileGenerator.gen_WriteOnlyDir()", "create new Dir" + fileName);
		
		file.setExecutable(false);
		file.setWritable(true);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_WriteOnlyDir()", "exit");
	}
	
	
	
	private void gen_ExcuteonlyFile(){
		LogCat.print("FileGenerator.gen_ExcutenOnlyDir()", "enter");
		
		File file = null;
		String fileName = "executeonly.txt";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		FileOutputStream fo;
		try{
		fo = cnx.openFileOutput(fileName, Context.MODE_PRIVATE);
		fo.write(" ".getBytes());
		LogCat.print("FileGenerator.gen_ExcuteOnlyFile()", "create new File" + fileName);
		fo.close();
		}catch (Exception e)
		{
			e.printStackTrace();
		}
		
		
		file.setExecutable(true);
		file.setWritable(false);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		LogCat.print("FileGenerator.gen_ExcuteOnlyFile()", "exit");
	}
	
	private void gen_ExcuteonlyDir(){
		LogCat.print("FileGenerator.gen_ExcuteonlyDir()", "enter");

		File file = null;
		String fileName = "EXECUTEONLY";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		file.mkdir();
		LogCat.print("FileGenerator.gen_ExcuteonlyDir()", "create new Dir" + fileName);
		
		file.setExecutable(true);
		file.setWritable(false);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_ExcuteonlyDir()", "exit");
	}
	
	private void gen_noRWXFile(){
		LogCat.print("FileGenerator.gen_noRWXFile()", "enter");
		
		File file = null;
		String fileName = "noRWX.txt";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		FileOutputStream fo;
		try{
		fo = cnx.openFileOutput(fileName, Context.MODE_PRIVATE);
		fo.write(" ".getBytes());
		LogCat.print("FileGenerator.gen_noRWXFile()", "create new File" + fileName);
		fo.close();
		}catch (Exception e)
		{
			e.printStackTrace();
		}
		
		
		file.setExecutable(false);
		file.setWritable(false);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_noRWXFile()", "exit");
	}
	
	private void gen_noRWXDir(){
		LogCat.print("FileGenerator.gen_noRWXDir()", "enter");
		
		File file = null;
		String fileName = "NORWX";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		
		file.mkdir();
		LogCat.print("FileGenerator.gen_noRWXDir()", "create new File" + fileName);
		
		file.setExecutable(false);
		file.setWritable(false);
		file.setReadable(false);
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_noRWXDir()", "exit");
	}
	
	private void gen_EmptyFile(){
		LogCat.print("FileGenerator.gen_EnptyFile()", "enter");

		File file = null;
		String fileName = "empty.txt";
		
		file = new File(cnx.getFilesDir() + "/" + fileName);
		if(file.exists())
		{
			file.delete();
		}
		try {
			file.createNewFile();
			LogCat.print("FileGenerator.gen_EnptyFile()", "create new File" + fileName);
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if(file.exists())
		{
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_EnptyFile()", "exit");
		
	}
	
	private void check_ExternStorage()
	{
		LogCat.print("FileGenerator.check_ExternStorage()", "enter");
		
		String state = Environment.getExternalStorageState();
		
		Log.i(tag, "Environment.getExternalStorageState=" + state);
		if (Environment.MEDIA_MOUNTED.equals(state)) {
		    // We can read and write the media
		    mExternalStorageAvailable = mExternalStorageWriteable = true;
		} else if (Environment.MEDIA_MOUNTED_READ_ONLY.equals(state)) {
		    // We can only read the media
		    mExternalStorageAvailable = true;
		    mExternalStorageWriteable = false;
		} else {
		    // Something else is wrong. It may be one of many other states, but all we need
		    //  to know is we can neither read nor write
		    mExternalStorageAvailable = mExternalStorageWriteable = false;
		}
		
		LogCat.print("FileGenerator.check_ExternStorage()", 
				"extern storage available:" + this.mExternalStorageAvailable);
		
		LogCat.print("FileGenerator.check_ExternStorage()", 
				"extern storage writable:" + this.mExternalStorageWriteable);
	}
	

	private void gen_BigFile(){
		LogCat.print("FileGenerator.gen_BigFile()", "enter");
		
		File file = null;
		check_ExternStorage();
		
		
		String fileName = "big.txt";
		
		File dir = Environment.getExternalStorageDirectory();
		
		
		
		file = new File(dir, fileName);
		if(file.exists())
		{
			files.add(file);
			LogCat.print(tag, "big file added");
			return;
		}
		
		byte[] buffer = "This is going to be as huge as possible\n".getBytes();
		
		LogCat.print(tag, "buffer.length: " + buffer.length);
		int number_of_lines = 50000000;

		FileChannel rwChannel;
		try {
			file.createNewFile();

			rwChannel = new RandomAccessFile(file, "rw").getChannel();
			ByteBuffer wrBuf = rwChannel.map(FileChannel.MapMode.READ_WRITE, 0, buffer.length * number_of_lines);
			for (int i = 0; i < number_of_lines; i++)
			{
			    wrBuf.put(buffer);
			}
			rwChannel.close();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		
		if(file.exists())
		{
			LogCat.print(tag, "big file created");
			files.add(file);
		}
		
		LogCat.print("FileGenerator.gen_BigFile()", "exit");
	}
	
	private void gen_RootFile() {
		LogCat.print("FileGenerator.gen_RootFile()", "enter");
		
		File file = null;
		file = new File("/proc/stat");
		//files.add(file);
		if(file.exists())
		{
			LogCat.print(tag, "root file added");
			files.add(file);
		}else
		{
			LogCat.print(tag, "file.exists()=" + file.exists());
		}
		LogCat.print("FileGenerator.gen_RootFile()", "exit");
	}
	
	private void gen_RootDir() {
		LogCat.print("FileGenerator.gen_RootDir()", "enter");
		File file = null;
		file = new File("/proc");
		//files.add(file);
		if(file.exists())
		{
			LogCat.print(tag, "root dir added");
			files.add(file);
		}else
		{
			LogCat.print(tag, "file.exists()=" + file.exists());
		}
		LogCat.print("FileGenerator.gen_RootDir()", "exit");
	}
	

	private void gen_WeirdNameFile(){
		LogCat.print("FileGenerator.gen_WeirdNameFile()", "enter");
		
		File file = null;

		OutputStream fo;
		ArrayList<String> dirs = new ArrayList<String>();
		String absDir = cnx.getFilesDir().getAbsolutePath() + "/";
		String dir = "";
		
		
		dir = absDir + "1----";
		dir = absDir + "$PATH$:";
		dir = absDir + "\64\2\67\34";
		dir = absDir + "----";
		dir = absDir + "--.-%DIR%-";
		dir = absDir + "%DIR%-";
		dir = absDir + ".";
		dir = absDir + "-";
		dir = absDir + "\01\01\01\01\01\01\01\01\01\01\01\01";
		dir = absDir + "\00\00\00\00";
		dir = absDir + "\177\177\177\177\177\177\177\177\177";
		dir = absDir + "######";
		dir = absDir + "\140echo 1";
		dir = absDir + "\140;echo 1";
		dir = absDir + "\140echo 1";
		
		
		
		try {
			for(String oneDir : dirs) {
			
				//Log.d("dir", oneDir);
				File dirFile = new File(oneDir);
				boolean isMkdir = dirFile.mkdirs();
				
				String fileName = "gen_WiredNameFile.txt";
				fileName = oneDir + fileName;
				
				//fileName = cnx.getFilesDir() + fileName;
				file = new File(fileName);
				if(file.exists()) file.delete();
				
				
				
				Log.i("Open File", fileName);
				fo = new BufferedOutputStream(new FileOutputStream(fileName, true)); 
				Log.i("-Open File", fileName);
				
				fo.write("xx".getBytes());
				fo.flush();
				fo.close();
				
				files.add(file);
				//Log.i(">>>>files Size:, ", files.size() + "");
				LogCat.print("FileGenerator.gen_WeirdNameFile()", 
						"create new File" + file.getName());
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		
		LogCat.print("FileGenerator.gen_WeirdNameFile()", "Dir Size: " + dirs.size());
		
		//files.add(file);
		LogCat.print("FileGenerator.gen_WeirdNameFile()", "exit");
	}
	
	private void gen_WeirdNameDir() {
		LogCat.print("FileGenerator.gen_WeirdNameDir()", "enter");
		File file = null;

		OutputStream fo;
		ArrayList<String> dirs = new ArrayList<String>();
		String absDir = cnx.getFilesDir().getAbsolutePath() + "/";
		String dir = "";
		
		
		dir = absDir + "1----/";
		dirs.add(dir);
		//Log.d("dir", dir);
		
		dir = absDir + "$PATH$:/";
		dirs.add(dir);
		//Log.d("dir", dir);
		
		dir = absDir + "\64\2\67\34/";
		dirs.add(dir);
		
		dir = absDir + "----/";
		dirs.add(dir);
		
		
		dir = absDir + "--.-%DIR%-/";
		dirs.add(dir);
		
		dir = absDir + "%DIR%-/";
		dirs.add(dir);
		
		dir = absDir + "./.";
		dirs.add(dir);
		
		dir = absDir + "-/";
		dirs.add(dir);
		
		dir = absDir + "\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01\01";
		dirs.add(dir);
		
		dir = absDir + "\00\00\00\00";
		dirs.add(dir);
		
		dir = absDir + "\177\177\177\177\177\177\177\177\177";
		dirs.add(dir);
		
		dir = absDir + "######";
		dirs.add(dir);
		
		dir = absDir + "\140echo 1";
		dirs.add(dir);
		
		dir = absDir + "\140;echo 1";
		dirs.add(dir);
		
		dir = absDir + "\140echo 1";
		dirs.add(dir);
		
		
		
		try {
			for(String oneDir : dirs) {
			
				//Log.d("dir", oneDir);
				File dirFile = new File(oneDir);
				boolean isMkdir = dirFile.mkdirs();
				
				String fileName = "gen_WiredDirName.txt";
				fileName = oneDir + "/" + fileName;
				//fileName = cnx.getFilesDir() + "/" + fileName;
				
				file = new File(fileName);
				if(file.exists()) file.delete();
				
				Log.i("Open File", fileName);
				fo = new BufferedOutputStream(new FileOutputStream(fileName, true)); 
				Log.i("-Open File", fileName);
				
				fo.write("xx".getBytes());
				fo.flush();
				fo.close();
				
				files.add(file);
				
				//Log.i(">>>>files Size:, ", files.size()+"");
				
				LogCat.print("FileGenerator.gen_WeirdNameDir()", 
						"create new File" + file.getName());
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		
		LogCat.print("FileGenerator.gen_WeirdNameDir()", "Dir Size: " + dirs.size());
		
		LogCat.print("FileGenerator.gen_WeirdNameDir()", "exit");
	}
	
}
