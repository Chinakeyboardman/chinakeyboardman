package paint2;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.util.*;

public class DukePaint extends JPanel implements ActionListener,MouseListener,MouseMotionListener
{
	private static final int WIDTH=800,HEIGHT=400;
	ArrayList<SimpleShape> shapes=new ArrayList<SimpleShape>();
	SimpleShape shape;
	JFrame frame=new JFrame("画板");
	JPanel pTop=new JPanel();
	JComboBox<String> cmbShape=new JComboBox<String>((String[])shapeNames.toArray());
	JComboBox<String> cmbColor=new JComboBox<String>((String[])colorNames.toArray());
	JButton btnClear=new JButton("清除内容");
	JButton btnUndo=new JButton("撤销");
	
	private boolean drawingOn=false;
	
	static java.util.List<Class<? extends SimpleShape>> shapeTypes=Collections.unmodifiableList(
						Arrays.asList(
						Line.class,Circle.class,Rect.class,Profile.class));
	static java.util.List<String> shapeNames=Collections.unmodifiableList(Arrays.asList("直线","椭圆","矩形","曲线"));
	static java.util.List<String> colorNames=Collections.unmodifiableList(Arrays.asList("黑色","蓝色","青色","暗灰",
		"灰色","绿色","亮灰","洋红","桔黄","粉红","红色","白色","黄色"));
	static java.util.List<Color> colorTypes=Collections.unmodifiableList(Arrays.asList(Color.black,Color.blue,Color.cyan,
		Color.darkGray,Color.gray,Color.green,Color.lightGray,Color.magenta,Color.orange,Color.pink,Color.red,
		Color.white,Color.yellow));
	static Map<String,Color> mapColor=new HashMap<String,Color>();
	static Map<String,Class<? extends SimpleShape>> mapShape=new HashMap<String,Class<? extends SimpleShape>>();

	static
	{
		for(int i=0;i<shapeTypes.size();i++)
		{
			mapShape.put(shapeNames.get(i),shapeTypes.get(i));
		}
		for(int i=0;i<colorNames.size();i++)
		{
			mapColor.put(colorNames.get(i),colorTypes.get(i));
		}
	}
	
	public DukePaint()
	{
		frame.setSize(WIDTH,HEIGHT);
		frame.setResizable(false);
		frame.setBackground(Color.white);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setLocationRelativeTo(null);
		
		
		pTop.setLayout(new FlowLayout());
		pTop.add(new JLabel("形状"));
		pTop.add(cmbShape);
		pTop.add(new JLabel("颜色"));
		pTop.add(cmbColor);
		pTop.add(btnUndo);
		pTop.add(btnClear);
		frame.add(pTop,BorderLayout.NORTH);
		
		Color c=new Color(1.0f,1.0f,1.0f);
		setBackground(c);
		frame.add(this,BorderLayout.CENTER);
		
		btnClear.addActionListener(this);
		btnUndo.addActionListener(this);
		addMouseListener(this);
		addMouseMotionListener(this);
		frame.setVisible(true);
		new PaintThread().start();//多线程重绘
	}
	private void clearPaintBoard()
	{
		shapes.clear();
		shape=null;
	}
	private void undo()
	{
		if(shapes.size()==0) return;
		shapes.remove(shapes.size()-1);
	}
	public static void main(String... args)
	{
		new DukePaint();
	}
	@Override
	public void actionPerformed(ActionEvent e)
	{
		Object o=e.getSource();
		if(o==btnClear)
		{
			clearPaintBoard();
		}
		else if(o==btnUndo)
		{
			undo();
		}
	}
	@Override
	public void mouseClicked(MouseEvent e)
	{}
	@Override
	public void mouseEntered(MouseEvent e)
	{}
	@Override
	public void mouseExited(MouseEvent e)
	{}
	@Override
	public void mousePressed(MouseEvent e)
	{
		Point p=new Point(e.getX(),e.getY());
		Color c=mapColor.get((String)cmbColor.getSelectedItem());
		String type=(String)cmbShape.getSelectedItem();
		Class<? extends SimpleShape> shapeClass=mapShape.get(type);
		
		try
		{
			shape=shapeClass.newInstance();
			shape.setColor(c);
			shape.setP1(p);
			drawingOn=true;
		}
		catch(Exception ex)
		{
			ex.printStackTrace();
		}
		
	}
	@Override
	public void mouseReleased(MouseEvent e)
	{
		Point p=new Point(e.getX(),e.getY());
		shape.setP2(p);
		shapes.add(shape);
		drawingOn=false;
	}
	@Override
	public void mouseDragged(MouseEvent e)
	{		
		if(!drawingOn) return;
		Point p=new Point(e.getX(),e.getY());
		shape.setP2(p);
}
	@Override
	public void mouseMoved(MouseEvent e)
	{
	}
	@Override
	public void paintComponent(Graphics g)
	{
		super.paintComponent(g);
		if(drawingOn) shape.draw(g);
		for(SimpleShape s:shapes)
		{
			s.draw(g);
		}
	}
	private class PaintThread extends Thread
	{
		public void run()
		{
			while(true)
			{
				repaint();
				try
				{
					Thread.sleep(120);
				}
				catch(InterruptedException e)
				{
					e.printStackTrace();
				}
			}
		}
	}
}