package paint2;

import java.awt.*;
import java.util.*;

abstract class SimpleShape
{
	protected Color color;
	protected Point p1,p2;
	protected abstract void draw(Graphics g);
	public void setP1(Point p)
	{
		p1=p;
	}
	public void setP2(Point p)
	{
		p2=p;
	}
	public void setColor(Color c)
	{
		color=c;
	}
	private Rectangle getRectangle()
	{
		if(p1==null || p2==null) return null;
		int x1=p1.x,x2=p2.x;
		int y1=p1.y,y2=p2.y;
		if(x1>x2)
		{
			int t=x1;
			x1=x2;
			x2=t;
		}
		if(y1>y2)
		{
			int t=y1;
			y1=y2;
			y2=t;
		}
		Rectangle self=new Rectangle(x1,y1,x2-x1,y2-y1);
		return self;
	}
	public boolean intersects(Point p)
	{
		Rectangle self=getRectangle();
		if(self==null) return false;
		Rectangle rec=new Rectangle(p);
		return self.intersects(rec);
	}
	public boolean intersects(Rectangle r)
	{
		Rectangle self=getRectangle();
		if(self==null) return false;
		return self.intersects(r);
	}
}
class Circle extends SimpleShape
{
	public Circle(){}
	public Circle(Point first,Point last)
	{
		p1=first;
		p2=last;
	}
	public Circle(Color c)
	{
		color=c;
	}
	public Circle(Point p1,Color c)
	{
		this.p1=p1;
		color=c;
	}
	@Override
	public void draw(Graphics g)
	{
		if(p1==null || p2==null) return;
		//调整
		int x1=p1.x,x2=p2.x;
		int y1=p1.y,y2=p2.y;
		if(x1>x2)
		{
			int t=x1;
			x1=x2;
			x2=t;
		}
		if(y1>y2)
		{
			int t=y1;
			y1=y2;
			y2=t;
		}
		Color c=g.getColor();
		g.setColor(color);
		g.drawOval(x1,y1,x2-x1,y2-y1);
		g.setColor(c);
	}
}
class Profile extends SimpleShape
{
	private ArrayList<Point> points=new ArrayList<Point>();
	public Profile(){}
	public Profile(Color c)
	{
		color=c;
	}
	public Profile(Point p,Color c)
	{
		this(c);
		points.add(p);
	}
	@Override
	public void setP1(Point p)
	{
		points.add(0,p);
	}
	@Override
	public void setP2(Point p)
	{
		points.add(p);
	}
	@Override
	public void draw(Graphics g)
	{
		if(points.size()<2) return;
		Color c=g.getColor();
		g.setColor(color);
		Iterator<Point> itr=points.iterator();
		Point first=null,last=null;
		while(itr.hasNext())
		{
			Point p=itr.next();
			if(first==null)
			{
				first=p;
			}
			else
			{
				if(last==null)
				{
					last=p;
				}
				else
				{
					first=last;
					last=p;
				}
				g.drawLine(first.x,first.y,last.x,last.y);
			}
		}
		g.setColor(c);
	}
}
class Rect extends SimpleShape
{
	public Rect(){}
	public Rect(Point p1,Point p2)
	{
		this.p1=p1;
		this.p2=p2;
	}
	public Rect(Point p1,Point p2,Color c)
	{
		this(p1,p2);
		setColor(c);
	}
	public Rect(Point left,Color c)
	{
		p1=left;
		color=c;
	}
	@Override
	public void draw(Graphics g)
	{
		if(p1==null || p2==null) return;
		//调整
		int x1=p1.x,x2=p2.x;
		int y1=p1.y,y2=p2.y;
		if(x1>x2)
		{
			int t=x1;
			x1=x2;
			x2=t;
		}
		if(y1>y2)
		{
			int t=y1;
			y1=y2;
			y2=t;
		}
		Color c=g.getColor();
		g.setColor(color);
		g.drawRect(x1,y1,x2-x1,y2-y1);
		g.setColor(c);
	}
}
class Line extends SimpleShape
{
	public Line(){}
	public Line(Color c)
	{
		color=c;
	}
	public Line(Point p,Color c)
	{
		this(c);
		p1=p;
	}
	@Override
	public void draw(Graphics g)
	{
		if(p1==null || p2==null) return;
		Color c=g.getColor();
		g.setColor(color);
		g.drawLine(p1.x,p1.y,p2.x,p2.y);
		g.setColor(c);
	}
}
