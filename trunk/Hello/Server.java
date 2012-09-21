import java.io.IOException;
import java.net.*;
import java.nio.ByteBuffer;
import java.nio.channels.*;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.Set;
//a
public class Server {

  int i = 9;
	ServerSocketChannel ssc;
	SocketChannel socketChannel;
	ArrayList<SocketChannel> channels = new ArrayList<SocketChannel>();
	private ByteBuffer buffer = ByteBuffer.allocate(1024);

	public Server() throws IOException {
		ssc = ServerSocketChannel.open();
		ssc.configureBlocking(false);

		InetAddress lh = InetAddress.getLocalHost();
		final InetSocketAddress isa = new InetSocketAddress(lh, 1234);
		ssc.socket().bind(isa);

		Selector acceptSelector = Selector.open();
		ssc.register(acceptSelector, SelectionKey.OP_ACCEPT);
		System.out.println("waiting");
		while (acceptSelector.select() > 0) {
			Set<SelectionKey> readyKeys = acceptSelector.selectedKeys();
			Iterator<SelectionKey> i = readyKeys.iterator();
			while (i.hasNext()) {
				SelectionKey sk = i.next();
				i.remove();
				if (sk.isAcceptable()){
					ServerSocketChannel nextReady = (ServerSocketChannel) sk
							.channel();
					SocketChannel sc = nextReady.accept();
					sc.configureBlocking(false);
					channels.add(sc);
					sc.register(acceptSelector, SelectionKey.OP_READ);
				}
				if (sk.isReadable()){
					SocketChannel chan = (SocketChannel) sk.channel();
					buffer.clear();
					chan.read(buffer);
					for (SocketChannel ch : channels){
						buffer.flip();
						ch.write(buffer);
					}
				}
			}
			System.out.println("waiting");
		}
	}

	public static void main(String[] args) {
		try {
			new Server();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}

}
