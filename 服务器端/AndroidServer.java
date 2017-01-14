import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;

public class AndroidServer {

	public static void main(String [] args) throws IOException{
		ServerSocket server = new ServerSocket(9526);
		while(true){
			AcceptMess(server);
		}
	}
	
	public static void AcceptMess(ServerSocket server) throws IOException{
		Socket socket2 = server.accept();
//		InputStreamReader in = new InputStreamReader(socket2.getInputStream());
//		BufferedReader buff = new BufferedReader(in);
//		String mess = "null";
//		mess = buff.readLine();
		
		PrintStream out = new PrintStream(socket2.getOutputStream());

		//if(mess == "request mess"){
			File txt = new File("./store.txt");
			
			if(txt.exists()){
				File file = new File("/var/www/html/faceTestImg/");
				String [] list = file.list();
				int length = list.length - 1;
				
				out.println("http://115.29.109.27/faceTestImg/" + length + ".jpg");
				txt.delete();
			}
			else{
				String str = "no image";
				out.println(str);
			}
	//	}
		
		socket2.close();
		out.close();
//		in.close();
	}
}
